<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Traits\DataTable;
use Modules\Order\Exports\OrdersCoursesReportsExport;
use Modules\Order\Exports\OrdersReportsExport;
use Modules\Order\Http\Requests\Dashboard\OrderRequest;
use Modules\Order\Transformers\Dashboard\OrderResource;
use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as Status;
use Modules\Order\Notifications\Api\ResponseOrderNotification;
use Notification;

class OrderController extends Controller
{
    private $order;

    public function __construct(Order $order, Status $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function index()
    {
        return view('order::dashboard.orders.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function export()
    {
        $fileName = 'orders_reports_' . date("Y-m-d H:i:s") . '.xlsx';
        return Excel::download(new OrdersReportsExport($this->order), $fileName);
    }

    public function exportCourses()
    {
        $fileName = 'orders_courses_reports_' . date("Y-m-d H:i:s") . '.xlsx';
        return Excel::download(new OrdersCoursesReportsExport($this->order), $fileName);
    }

    public function show($id)
    {
        // $this->order->updateUnread($id);
        $order = $this->order->findById($id);
        //
        // Notification::route('mail', $order->email)
        // ->notify((new ResponseOrderNotification($order))->locale(locale()));
        $statuses = $this->status->getAll();
        return view('order::dashboard.orders.show', compact('order', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->order->update($request, $id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function changeExpireDate(Request $request)
    {
        try {
            $update = $this->order->changeExpireDate($request);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->order->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function note_orders(){
        $statuses = $this->status->getAll();
        return view('order::dashboard.note_orders.index', compact( 'statuses'));
    }

    public function course_orders(){
        $statuses = $this->status->getAll();
        return view('order::dashboard.course_orders.index', compact( 'statuses'));
    }

    public function package_orders(){
        $statuses = $this->status->getAll();
        return view('order::dashboard.package_orders.index', compact( 'statuses'));
    }

    public function pending_orders(){
        $statuses = $this->status->getAll();
        return view('order::dashboard.pending_orders.index', compact( 'statuses'));
    }
}
