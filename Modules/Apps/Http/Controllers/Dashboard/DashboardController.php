<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Authorization\Entities\Role;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\Exam;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Trainer\Entities\Trainer;
use Modules\User\Entities\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'coursesCount' => Course::active(),
            'notesCount' => Note::active(),
            'packagesCount' => Package::active(),
            'examsCount' => Exam::where('id','!=',null),
            'trainersCount' => User::whereHas('roles.permissions', function ($query) {
                $query->where('name', 'trainer_access');
            }),
            'usersCount' => User::doesnthave('roles'),

            'totalOrdersCount' => Order::where('id','!=',null),
            'pendingOrdersCount' => Order::where('order_status_id',3),
            'completedOrdersCount' => Order::where('order_status_id',1),
        ];
        foreach ($data as $key => $item) {
            $data[$key] = $this->filter($request,$item)->count();
        }
        $data['course_orders_total'] = $this->filter($request,Order::whereHas('orderCourses')->where('order_status_id',1))->sum('total');
        $data['note_orders_total'] = $this->filter($request,Order::whereHas('orderNotes')->where('order_status_id',1))->sum('total');
        $data['package_orders_total'] = $this->filter($request,Order::whereHas('orderPackages')->where('order_status_id',1))->sum('total');

        $data['total_profit'] = round($data['course_orders_total'] + $data['note_orders_total'] + $data['package_orders_total'],3);
        $data['total_profit'] = number_format((float)$data['total_profit'], 3, '.', '');
        return view('apps::dashboard.index',compact('data'));
    }
    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
}
