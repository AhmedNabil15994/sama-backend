<?php

namespace Modules\Course\Repositories\Frontend;

use Carbon\Carbon;
use Modules\Course\Entities\Course;
use Modules\Exam\Entities\Exam;
use Modules\Exam\Entities\QuestionAnswer;
use Modules\Exam\Entities\UserExam;

class CourseRepository
{
    private $course;

    public function __construct(Course $course)
    {
        $this->course = $course->withCount(['exams','resources','ReviewQuestions']);
    }

    public function getModelTranslatable()
    {
        $course = new Course;
        if(property_exists($course,'translatable')){
            return $course->translatable;
        }else{
            return [];
        }
    }

    public function getByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getEventsByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->where('is_online', false)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getCoursesByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->where('is_online', true)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->get();

        return $courses;
    }

    public function getLimitedEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->active()->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getLimitedCourses($order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->orderBy($order, $sort)->take(24)->get();
        return $courses;
    }

    public function getAllEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->active()->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getAllFilterCourses($request, $order = 'id', $sort = 'desc')
    {


        $courses = $this->course->active()
            ->where(function ($query) use ($request) {
                if ($request->category_id) {
                    $query->whereHas('categories', function ($query) use ($request) {
                        $query->where('category_id', $request->category_id);
                    });
                }
                if ($request->search) {

                    $query->where('id', 'like', '%' . $request->search . '%');
                    foreach ($this->getModelTranslatable() as $key) {

                        $query->orWhere($key . '->' . locale(), 'like', '%' . $request->search . '%');
                    }
                }
            });
        return $courses->orderBy($order, $sort)->paginate(10);
    }

    public function getAllCourses($request, $order = 'id', $sort = 'desc')
    {


        $courses = $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->where(function ($query) use ($request) {
                if ($request->category_id) {
                    $query->whereHas('categories', function ($query) use ($request) {
                        $query->where('category_id', $request->category_id);
                    });
                }
            });
        return $courses->orderBy($order, $sort)->get();
    }


    public function getCoursesByCategory()
    {


        $range = [];
        return  $this->course->active()->orderBy('order','asc')
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->when(request('categories'), fn ($q) => $q->categories(request('categories')))
            ->when(request('category_id'), fn ($q) => $q->categories((array)request('category_id')))
            ->when(request('s'), fn ($q, $val) => $q->search($val))
            ->when(
                request('price_from') && request('price_to'),
                fn ($q) => $q->whereBetween('price',  [request('price_from'), request('price_to')]),
            )->when(
                request('genders'),
                function ($q) {
                    $q->whereJsonContains('extra_attributes->gender', request('genders'));
                }
            );
    }


    public function subscribedCourses($order = 'id', $sort = 'desc')
    {
        return $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->withCount('orderCourse')
            ->whereHas(
                'orderCourse',
                fn ($q) => $q
                    ->whereUserId(auth()->id())
                    ->notExpired()
                    ->successPay()
            )
            ->orderBy($order, $sort)->get();
    }
    public function subscribedLiveCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->active()->where('is_live', 1)->withCount('orderCourse')->whereHas('orderCourse.order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            })->where('user_id', auth()->id());
        })->orderBy($order, $sort)->get();
    }

    public function findEventBySlug($slug)
    {
        return $this->course->active()->where('slug->' . locale(), $slug)->first();
    }

    public function findCourseBySlug($slug)
    {
        return $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->withCount('orderCourse', 'lessons')
            ->anyTranslation('slug', $slug)
            ->with('lessons.lessonContents.media', 'lessons.lessonContents.video', 'video', 'targets', 'activeCourseReviews', 'trainer')
            ->firstOrFail();
    }

    public function findCourseById($id)
    {
        return $this->course->active()
            ->withCount('orderCourse', 'lessons')
            ->with(
                'lessons.lessonContents.media',
                'lessons.lessonContents.video',
                'video',
                'targets',
                'activeCourseReviews',
                'trainer'
            )
            ->find($id);
            // ->findOrFail($id);
    }


    public function getCalenderCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->active()->where('is_live', 1)
            ->withCount('orderCourse')
            ->whereHas('orderCourse.order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                })->where('user_id', auth()->id());
            })
            ->orWhere('trainer_id', auth()->id())
            ->where('is_live', 1)
            ->orderBy($order, $sort)->get();
    }




    public function autoCompleteSearch($request)
    {
        return $this->course->active()->active()->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                foreach (config('translatable.locales') as $code) {
                    $query->orWhere('title->' . $code, 'like', '%' . $request->input('query') . '%');
                    $query->orWhere('slug->' . $code, 'like', '%' . $request->input('query') . '%');
                }
            });
        });
    }

    public function saveQuizAnswers($id,$request){
        foreach (\request()->answers as $examId => $answers){
            $examResult = 0;
            $correctCount = 0;
            $failedCount = 0;
            $userExamAnswer_arr = [];
            $userExams = [
                'user_id' => auth()->id(),
            ];
            $userExams['exam_id'] = $examId;

            $examObj = Exam::find($examId);
            $userExams['questions_count'] = count($answers);
            $userExams['correct_answers_count'] = $correctCount;
            $userExams['failed_answers_count'] = $failedCount;
            $userExams['exam_result'] = $examResult;
            $userExams['exam_degree'] = $examObj?->degree ?? 0;
            $userExams['success_degree'] = $examObj?->success_degree ?? 0;

            $checkObj = UserExam::where('user_id',auth()->id())->where('exam_id',$examId)->first();
            if(!$checkObj){
                $userExamObj = UserExam::create($userExams);

                foreach ($answers as $answerKey => $userExamAnswer){
                    $key = array_keys($userExamAnswer)[0];
                    $question_answer = QuestionAnswer::query()->where('id', $key)->first();
                    $correct_answer = $question_answer ? $question_answer->is_correct : 0;
                    $userExamAnswer_arr[] = [
                        'user_exam_id' => $userExamObj->id,
                        'question_id'   => $answerKey,
                        'question_answer_id' => $key,
                        'is_correct' => $correct_answer,
                        'degree' => $userExamAnswer[$key],
                    ];
                    $examResult+= $userExamAnswer[$key];
                    if ($correct_answer) {
                        $correctCount++;
                    } else {
                        $failedCount++;
                    }
//                    $correctCount+= $userExamAnswer[$key] ?? 0;
                }

                $userExamObj->update([
                    'exam_result'=> $examResult,
                    'correct_answers_count' => $correctCount,
                    'failed_answers_count' => $failedCount,
                ]);
                $userExamObj->userExamAnswers()->insert($userExamAnswer_arr);
            }else{
                return false;
            }
        }
        return true;
    }
}
