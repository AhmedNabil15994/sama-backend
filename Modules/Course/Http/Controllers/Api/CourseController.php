<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Route;
use Modules\Course\Entities\LessonContent;
use Modules\Course\Transformers\Api\{CourseResource,LessonResource,SemesterResource,ResourceResource};
use Modules\Course\Entities\UserVideo;
use Modules\Order\Entities\OrderCourse;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Course\Repositories\Frontend\CourseRepository;
use Modules\Semester\Repositories\Frontend\SemesterRepository;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;

class CourseController extends ApiController
{
    use PaymentTrait;

    public function __construct(public Order $order, public CourseRepository $courseRepository,public LessonContent $lessonContent, public SemesterRepository $semesterRepository)
    {
        if (request()->hasHeader('authorization'))
            $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        return CourseResource::collection($this->courseRepository->getAllFilterCourses($request));
    }

    public function runVideo($id,$type)
    {
        $lesson_content = null;
        $user_video = null;
        switch($type){
            case'lesson':
                $lesson = $this->lessonContent->active()->findOrFail($id);
                $url = $lesson->video_link;
                $lesson_content = $lesson;
                $user_video = UserVideo::query()->where('lesson_content_id', $lesson->id)->where('user_id', \request('user_id') ? \request('user_id') : null)->first();
                break;
            case'course_intro':
                $course = $this->courseRepository->findCourseById($id);
                $url = $course->intro_video;
                break;
        }

        return view('course::api.videos.show', ['videoUrl' => $url, 'lesson_content' => $lesson_content, 'user_video' => $user_video, 'user_id' => \request('user_id') ? \request('user_id') : '']);
    }


    public function show($id)
    {
        $course = $this->courseRepository->findCourseById($id);

        if (!$course)
            return $this->error(__("Course not found"));

        $semesters = $this->semesterRepository->getAllSemesters();
        $currentSemester = $this->semesterRepository->currentSemester();

        return LessonResource::collection($course?->lessons()->active()->semesterId($currentSemester->id)->orderBy('order', 'asc')->paginate(5))->additional([
            'semesters' => SemesterResource::collection($semesters),
            'current_semester' => new SemesterResource($currentSemester),
            'course_data' => new CourseResource($course),
        ]);
    }


    public function courseResources($id)
    {
        $currentSemester = $this->semesterRepository->currentSemester();
        $resources = $this->lessonContent->active()->TypeResource()
            ->whereHas('lesson',fn($q) => $q->active()->where('course_id',$id)->semesterId($currentSemester->id));

        return ResourceResource::collection($resources->orderBy('order','asc')->paginate(50));
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

    public function buyCourseInApp(Request $request, $id)
    {
        try {
            $course = $this->courseRepository->findCourseById($id);
            $order =  $this->order->BuySingleCourseInApp(auth()->id(), $course);
            return $this->response([]);
        } catch (\Exception $e) {
            return $this->error('Something went wrong');
        }
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


    public function complateLesson($lessonId)
    {
        $lesson = LessonContent::whereHas('lesson',fn($q) => $q->whereIn('course_id', auth()->user()->my_courses->pluck('id')->toArray()))->find($lessonId);

        if(!$lesson)
            return $this->error(__('lesson not found'));

        $complete_record = $lesson->userCompletes()->where('user_id' , auth()->id())->first();

        if(!$complete_record){

            $lesson->userCompletes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return $this->response([]);
    }
}
