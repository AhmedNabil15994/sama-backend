<?php

namespace Modules\Trainer\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Traits\DataTable;
use Modules\Trainer\Transformers\Dashboard\TrainerStatisticsResource;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;

use Modules\Core\Traits\Dashboard\CrudDashboardController;

class TrainerController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __crudConstruct;
}

    public function __construct()
    {
        $this->__crudConstruct();
        $this->model=new User();
    }

    public function statistics(Request $request){

        if($request->ajax()){
            $trainers = $this->repository->getTrainersProfit($request);

            $datatable = DataTable::drawTable($request,$trainers);
            $datatable['data'] = TrainerStatisticsResource::collection($datatable['data']);
            return Response()->json($datatable);
        }
        return view('trainer::dashboard.trainers.statistics');
    }
}
