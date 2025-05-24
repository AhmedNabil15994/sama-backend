<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Couchbase\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Authentication\Mail\WelcomeMail;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Route;
use Modules\Category\Entities\Category;
use Modules\Course\Entities\LessonContent;
use Modules\Course\Entities\Note;
use Modules\Course\Entities\UserVideo;
use Modules\Course\Repositories\Frontend\ReviewQuestionRepository;
use Modules\Course\Transformers\ClientSide\ReviewQuestionResource;
use Modules\Exam\Entities\Exam;
use Modules\Exam\Entities\UserExam;
use Modules\Order\Entities\OrderCourse;
use Modules\Course\Entities\CourseReview;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Course\Repositories\Frontend\CourseRepository;
use Modules\Category\Repositories\Frontend\CategoryRepository;
use Modules\Semester\Repositories\Frontend\SemesterRepository;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;

class CourseController extends Controller
{
    use PaymentTrait;

    public function __construct(
        public Order $order,
        public CourseRepository $courseRepository,
        public CategoryRepository $category,
        public SemesterRepository $semesterRepository,
        public ReviewQuestionRepository $reviewQuestionRepository,
    )
    {
    }

    public function index(Request $request)
    {

        $data['courses'] = $this->courseRepository->getCoursesByCategory()->get();

        $data['mainCategories'] = $this->category->mainCategories();
        return view('course::frontend.courses.index', $data);
    }

    public function show($slug)
    {
        $course = $this->courseRepository->findCourseBySlug($slug);

        if(!$course->current_user_hasAccess && !$course->status){
            abort(404);
        }

        if (!checkRouteLocale($course, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$course->slug]);
        }
        $semesters = $this->semesterRepository->getAllSemesters();
        $currentSemester = $this->semesterRepository->currentSemester();
        $reviewQuestions = ReviewQuestion::where('lesson_content_id', \request('lesson-content-id'))->active()->get();
        $lessons = $course->lessons()->active()->semesterId($currentSemester->id)->orderBy('order','asc')->get();

    $lesson_content = LessonContent::where('id', \request('lesson-content-id'))->active()->first();
        $user_video = '';
    if ($lesson_content) {
            $user_video = UserVideo::query()->where('lesson_content_id', $lesson_content->id)->where('user_id', auth()->id())->first();
        }
    $has_access =  $lesson_content ? ( $course->current_user_hasAccess || (auth()->id() && auth()->user()->can('dashboard_access'))) : ( $course->current_user_hasAccess || (auth()->id() && auth()->user()->can('dashboard_access')) || $lesson_content?->is_free );

        $lesson_type = $lesson_content ? $lesson_content->type : null;
        return view('course::frontend.courses.show', compact('course', 'reviewQuestions', 'semesters', 'currentSemester', 'lessons', 'has_access', 'lesson_content', 'lesson_type', 'user_video'));
    }

    public function getReviewQuestions()
    {
        $course = $this->courseRepository->findCourseById(\request('course_id'));

        if(!$course->current_user_hasAccess && !$course->status){
            abort(404);
        }
        $reviewQuestions = ReviewQuestion::where('course_id', $course->id)->where('lesson_content_id', \request('lesson_content_id'))->active()->get();
        return response()->json([
            'html' => view('course::frontend.courses.show-partials.course-review-questions', compact('reviewQuestions'))->render()
        ]);
    }

    public function getLessonContent()
    {
        $course = $this->courseRepository->findCourseById(\request('course_id'));

        if(!$course->current_user_hasAccess && !$course->status){
            abort(404);
        }
        $lessonContent = LessonContent::where('id', \request('lesson_content_id'))->active()->first();
        $reviewQuestions = ReviewQuestion::where('course_id', $course->id)->where('lesson_content_id', $lessonContent)->active()->get();
        $has_access =  $course->current_user_hasAccess || (\request('user_id') && \request('dashboard_access')) || $lessonContent->is_free;
        return response()->json([
            'html' => view('course::frontend.courses.show-partials.show_lesson_content', compact('lessonContent', 'course', 'reviewQuestions', 'has_access'))->render()
        ]);
    }

    public function live($id)
    {
        $course = Course::where('is_live', 1)->with('trainer', 'meeting')->find($id);
        if (count($course->subscribed) <= 0 && $course->trainer_id != auth()->id()) {
            abort(404);
        }
        return view('course::frontend.courses.zoom-show', compact('course'));
    }

    public function buy(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('frontend.register');
        } else {
            $user = auth()->user();
        }

        $data['user_id'] = $user->id;

        $course = $this->courseRepository->findCourseById($id);
        $order =  $this->order->BuySingleCourse($request, $course);
        $payment = $this->getPaymentGateway('tap');
        $data = $payment->send($order, 'orders');
        return redirect($data['url']);
    }


    public function CourseCertification($id)
    {
        $orderCourse = OrderCourse::with('course', 'user')
            ->where('course_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();



        // abort_if(!$orderCourse->course->isFinished() || !$orderCourse->course->is_certificated, 404);


        return  view('course::frontend.courses.certification', compact('orderCourse'));

        // $pdf = PDF::loadView('course::frontend.courses.certification', compact('orderCourse'))
        //     ->setPaper([0, 0, 567.00, 883.80], 'landscape');

        // return $pdf->stream();
        // return $pdf->download('certification');
    }

    public function quizAnswers($id, Request $request){
        optional(auth()->user()->userExams()->where('exam_id' , $request->exam_id)->first())->delete();
        $checkAvailability = $this->courseRepository->saveQuizAnswers($id , $request);
        if (!$checkAvailability) {
            return redirect()->back()->with([
                'status' => __('course::frontend.Quiz had been answered before') ,
                'alert' => 'danger' ,
            ]);
        }
        $userExam = UserExam::query()->where('user_id' , auth()->id())->where('exam_id' , $request->exam_id)->with('exam')->first();
        $msg = __('course::frontend.Answers Saved Successfully') .' '. __('course::frontend.Result Exam') . $userExam?->exam_result . '%' . '<br>' . __('course::frontend.Correct Answer Count') . ' ' . $userExam?->correct_answers_count . '<br>' . __('course::frontend.Failed Answer Count') . ' ' . $userExam?->failed_answers_count;
        return redirect()->back()->with([
            'status' => $msg,
            'alert' => 'success' ,
        ]);
    }

    public function notes(){
        $notes = Note::active()->showInHome()->orderBy('id','desc')->get();
        return  view('course::frontend.courses.notes.index', compact('notes'));

    }
}
