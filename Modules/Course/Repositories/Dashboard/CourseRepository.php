<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Course\Service\CourseTargetService;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class CourseRepository extends CrudRepository
{
    public CourseTargetService $courseTargetService;

    public function __construct()
    {
        parent::__construct(Course::class);
        $this->statusAttribute     = ['is_certificated', 'is_live','status'];
        $this->fileAttribute       = ['image' => 'image'];
        $this->courseTargetService = new CourseTargetService();
    }
    
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->is_live) {
            $data['extra_attributes']['days'] = implode(',', $request['days_status']);
        }
        return $data;
    }
    public function modelCreated($model, $request, $is_created = true): void
    {
        $model->categories()->sync(int_to_array($request->category_id));
        $this->courseTargetService->handelTargets($model, $request);
    }
    public function modelUpdated($model, $request): void
    {
        $model->categories()->sync(int_to_array($request->category_id));
        $this->courseTargetService->handelTargets($model, $request);
    }

    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        $query
            ->when(data_get($request, 'req.categories'), fn ($q, $v) => $q->categories((array)$v))
            ->when(data_get($request, 'req.trainer'), fn ($q, $v) => $q->trainer($v));


        return $query;
    }
}
