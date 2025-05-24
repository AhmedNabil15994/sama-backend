<?php

namespace Modules\Course\Http\Controllers\Trainer;

use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Entities\Lesson;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;
use Modules\User\Entities\User;

class CourseController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }
    private $video_api;

    public function __construct(Course $course)
    {

        $this->__tConstruct();
        $this->model = $course;
    }

    public function extraData($model)
    {
        return [
            'model' => $model,
            'trainersArr' => User::where('id', '=', auth()->id())->whereHas('roles.permissions', function ($query) {
                $query->where('name', 'trainer_access');
            }),
        ];
    }



    public function courses()
    {
        $courses = Course::with('lessons')
            ->when(
                request('search'),
                fn ($q, $val) => $q->search($val)
            )
            ->when(
                (array)request('category_id'),
                fn ($q, $val) => $q->categories($val)
            )
            ->get();
        return  response()->json($courses);
    }


    public function getlessonsWithCourseId($course)
    {
        $records = Lesson::where("course_id", $course)->get(['id','title']);
        return response()->json($records);
    }
}
