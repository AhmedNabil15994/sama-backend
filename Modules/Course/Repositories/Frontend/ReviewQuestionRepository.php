<?php

namespace Modules\Course\Repositories\Frontend;

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
            $question =  $this->question->create([
                'course_id' => $courseId,
                'user_id' => auth()->user()->id,
                'question' => $request->question,
                'lesson_content_id' => $request->lesson_content_id,
            ]);
            if($request->hasFile('image')){
                $question->addMedia($request->file('image'))->toMediaCollection('images');
            }
            return $question;

        }

        return false;
    }

    public function addAnswer(Request $request,$questionId)
    {
        $question = $this->findQuestionById($questionId);

        if($question){

            $answer = $question->answers()->create([
                'user_id' => auth()->user()->id,
                'answer' => $request->answer,
            ]);
            if($request->hasFile('image')){
                $answer->addMedia($request->file('image'))->toMediaCollection('images');
            }
            return $answer;
        }

        return false;
    }
}
