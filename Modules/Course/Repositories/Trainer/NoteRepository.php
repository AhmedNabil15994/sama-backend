<?php

namespace Modules\Course\Repositories\Trainer;

use Illuminate\Http\Request;
use Modules\Course\Entities\Note;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseTarget;
use Modules\Course\Service\CourseService;
use Modules\Course\Service\CourseDateService;
use Modules\Course\Service\CourseTargetService;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class NoteRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Note::class);
    }

    public $fileAttribute = ["image" => "images", 'pdf' => 'pdf'];

    /**
     * Status attribute in model
     * @var array
     */
    protected array $statusAttribute = ["status","is_free"];

    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        $userId = auth()->user()->id;
        if($userId){
            $query = $query->trainer($userId);
        }
        $query->when(
            data_get($request, 'req.trainer'),
            function ($q) use ($request) {
                $q->trainer(data_get($request, 'req.trainer'));
            }
        );
        return $query;
    }
}
