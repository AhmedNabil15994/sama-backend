<?php

namespace Modules\Exam\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Exam\Entities\UserExam;

class UserExamRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(UserExam::class);
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['user_id']) && $request['req']['user_id'] != null) {
            $query->where('user_id', $request['req']['user_id']);
        }

        if (isset($request['req']['exam_id']) && $request['req']['exam_id'] != null) {
            $query->where('exam_id', $request['req']['exam_id']);
        }

        if (isset($request['req']['course_id']) && $request['req']['course_id'] != null) {
            $query->whereHas('exam', function ($q) use ($request) {
                $q->where('course_id', $request['req']['course_id']);
            });
        }

        if (isset($request['req']['trainer_id']) && $request['req']['trainer_id'] != null) {
            $query->whereHas('exam', function ($q) use ($request) {
                $q->where('trainer_id', $request['req']['trainer_id']);
            });
        }

        return $query;
    }
}
