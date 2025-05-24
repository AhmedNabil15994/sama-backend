<?php

namespace Modules\Exam\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Entities\Course;

class ExamController extends Controller
{
    use CrudDashboardController;

    public function getTrainerCourses($id){
        return response()->json([
            'courses' => Course::whereTrainerId($id)->get(['title','id'])
        ]);
    }

}
