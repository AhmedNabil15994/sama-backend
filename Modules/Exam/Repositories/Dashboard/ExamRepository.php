<?php

namespace Modules\Exam\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;

class ExamRepository extends CrudRepository
{
    //

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

        if (isset($request['req']['trainer_id'])) {
            $query->where('trainer_id', $request['req']['trainer_id']);
        }

        if (isset($request['req']['course_id'])) {
            $query->where('course_id', $request['req']['course_id']);
        }

        return $query;
    }
}
