<?php

namespace Modules\Course\ViewComposers\Trainer;

use Modules\Course\Repositories\Trainer\CourseRepository as Course;
use Illuminate\View\View;
use Cache;

class CourseComposer
{
    public $courses = [];

    public function __construct(Course $course)
    {
        $this->courses =  $course->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('courses', $this->courses);
    }
}
