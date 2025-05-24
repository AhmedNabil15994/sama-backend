<?php

namespace Modules\Course\Repositories\ClientSide;

use Modules\Course\Entities\ReviewQuestion;
use Modules\Course\Entities\ReviewQuestionAnswer;
use Illuminate\Http\Request;
use Modules\Course\Repositories\Frontend\CourseRepository;

class ReviewQuestionRepository
{

    public function __construct(private ReviewQuestion $question,private ReviewQuestionAnswer $answer,private CourseRepository $courseRepository)
    {
    }

    public function getQuestionsAndAnswersWithCourseId($courseId)
    {
        return $this->question->active()
            ->where('course_id',$courseId)
            ->latest()->paginate(10);
    }


    public function getCourseQuestionsReviews()
    {
        return $this->question->active()
            ->where('course_id',\request('course_id'))
            ->where('lesson_content_id', \request('lesson_id'))
            ->latest()->paginate(10);
    }

    public function getQuestionAnswersWithQuestionId($questionId)
    {
        ReviewQuestion::findOrFail($questionId);

        return ReviewQuestionAnswer::where('review_question_id' ,$questionId )
            ->latest()
            ->paginate(10);
    }

    public function findQuestionBycourseIDAndId($courseId,$id)
    {
        $course = $this->courseRepository->findCourseById($courseId);

        if($course){

            return $this->question->active()
            ->where('course_id',$courseId)
            ->find($id);
        }

        return false;
    }

    public function findQuestionById($id)
    {
        return $this->question->active()->find($id);
    }

    public function addQuestion(Request $request,$courseId)
    {
        $course = $this->courseRepository->findCourseById($courseId);

        if($course){

            return $this->question->create([
                'course_id' => $courseId,
                'user_id' => auth()->user()->id,
                'question' => $request->question,
                'lesson_content_id' => $request->lesson_content_id,
            ]);
        }

        return false;
    }

    public function addNewQuestion(Request $request)
    {
        $course = $this->courseRepository->findCourseById($request->course_id);

        if($course){

            return $this->question->create([
                'course_id' => $request->course_id,
                'user_id' => auth()->user()->id,
                'question' => $request->question,
                'lesson_content_id' => $request->lesson_id,
            ]);
        }

        return false;
    }

    public function addAnswer(Request $request,$questionId)
    {
        $question = $this->findQuestionById($questionId);

        if($question){

            return $question->answers()->create([
                'user_id' => auth()->user()->id,
                'answer' => $request->answer,
            ]);
        }

        return false;
    }
}
