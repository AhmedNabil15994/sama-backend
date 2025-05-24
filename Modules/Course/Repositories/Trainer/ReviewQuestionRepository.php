<?php

namespace Modules\Course\Repositories\Trainer;

use Illuminate\Http\Request;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ReviewQuestionRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(ReviewQuestion::class);
    }


    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        $userId = auth()->user()->id;
        if($userId){
            $query = $query->whereHas('course',function ($course) use ($userId){
                $course->trainer($userId);
            });
        }
        $query->when(
            data_get($request, 'req.course_id'),
            function ($q) use ($request) {
                $q->where('course_id',data_get($request, 'req.course_id'));
            }
        );
        return $query;
    }

    public function modelUpdated($model, $request, $is_created = true): void
    {
        if($request->answer && $request->answer != null && $request->review_question_id != null){
            $this->model->answers()->insert([
                'user_id' => auth()->id(),
                'answer' => $request->answer,
                'review_question_id' => $request->review_question_id,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ]);
        }
    }
}
