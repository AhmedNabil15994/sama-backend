<?php

namespace Modules\Order\Repositories\Frontend;

use Auth;
use CartTrait;
use Carbon\Carbon;
use Modules\Coupon\Http\Controllers\Frontend\CouponController;
use Modules\Course\Entities\Note;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Notifications\NewCourseEnrollmentNotification;
use Modules\Order\Entities\OrderCourse;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Package\Entities\PackagePrice;

class OrderRepository
{
    use OrderCalculationTrait;

    public function __construct(Order $order, OrderStatus $status, Course $course,Address $address)
    {
        $this->course = $course;
        $this->order = $order;
        $this->status = $status;
        $this->address = $address;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function getAllByUserID($userId)
    {
        return $this->order->where('user_id', $userId)->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }


    public function createOrderEvent($event, $status = true)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(false);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $event['price'],
                'total' => $event['price'],
                'user_id' => auth()->id(),
                'order_status_id' => $status->id,
            ]);


            $this->orderEvent($order, $event);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create($request, $status = 3)
    {

        try {
            DB::beginTransaction();

            $data = $this->calculateTheOrder($request);
            $status = $this->statusOfOrder(3);

            if (!$data) {
                return false;
            }

            if($request->coupon_code){
                $coupon_data = (new CouponController)->getCouponData($request->coupon_code,$data['total']);
            }else{
                $coupon_data = null;
            }

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => $coupon_data && $coupon_data[0] ? $coupon_data[1]['coupon_value'] : 0.000,
                'total' => $coupon_data && $coupon_data[0] ? $coupon_data[1]['total'] : $data['total'],
                'subtotal' => $data['subtotal'],
                'user_id' => $request->user_id,
                'order_status_id' => $status->id,
            ]);

            $address = $order->user->address;
            if($address){
                $address->update([
                    'type'       => $request['type'],
                    'state_id'   => $request['state_id'],
                    'widget'     => $request['widget'],
                    'street'     => $request['street'],
                    'gada'       => $request['gada'],
                    'building'   => $request['building'],
                    'details'    => $request['details'],
                    'floor'      => $request['floor'],
                    'flat'       => $request['flat'],
                    'user_id'    => auth()->id(),
                ]);
            }else{
                $this->address->create([
                    'type'       => $request['type'],
                    'state_id'   => $request['state_id'],
                    'widget'     => $request['widget'],
                    'street'     => $request['street'],
                    'gada'       => $request['gada'],
                    'building'   => $request['building'],
                    'details'    => $request['details'],
                    'floor'      => $request['floor'],
                    'flat'       => $request['flat'],
                    'user_id'    => auth()->id(),
                ]);
            }

            if($request['name'] && $request['name'] != ''){
                $order->user->update(['name'=> $request['name']]);
            }
            $this->orderCourses($order, $data);
            $this->orderNotes($order, $data);
            $this->orderPackages($order, $data);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function BuySingleCourse($request, $course)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(1);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $course->price,
                'total' => $course->price,
                'user_id' => auth()->user()->id,
                'order_status_id' => $status->id,
            ]);

            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $course->price,
                'trainer_id'   => $course->trainer_id,
                'user_id'      => auth()->user()->id,
                'expired_date' => $course->extra_attributes->get('end_date', null),
            ]);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function BuySingleCourseInApp($userID, $course)
    {
        DB::beginTransaction();
        try {
            $status = $this->statusOfOrder(1);

            $order = $this->order->create([
                'is_holding' => false,
                'discount' => 0.000,
                'subtotal' => $course->apple_price,
                'total' => $course->apple_price,
                'user_id' => $userID,
                'order_status_id' => $status->id,
            ]);

            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $course->apple_price,
                'trainer_id'   => $course->trainer_id,
                'user_id'      => $userID,
                'expired_date' => $course->extra_attributes->get('end_date', null),
            ]);

            if (request('transaction_id')) {
                $order->transactions()->updateOrCreate(
                    [
                        'transaction_id'  => request('transaction_id')
                    ],
                    [
                        'method'    => 'Apple Pay',
                        'tran_id'       => request('transaction_id'),
                        'payment_id'    => request('transaction_id'),
                    ]
                );
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function orderCourses($order, $data)
    {
        foreach ($data['order_courses'] as $key => $orderCourse) {
            $course = $orderCourse['course'];
            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $orderCourse['total'],
                'trainer_id'   => $course->trainer_id,
                'user_id'      => auth()->user()->id,
                'expired_date' => $course->extra_attributes->get('end_date', null),
            ]);
        }
    }

    public function orderNotes($order, $data)
    {
        foreach ($data['order_notes'] as $orderNote) {
            $note = $orderNote['note'];

            $order->orderNotes()->create([
                'note_id'    => $note->id,
                'total'    => $orderNote['total'],
                'trainer_id'   => $note->trainer_id,
            ]);
        }
    }

    public function orderPackages($order, $data)
    {
        foreach ($data['order_packages'] as $orderPackage) {
            $packagePrice = $orderPackage['package'];
            $package = $packagePrice->package;

            $order->orderPackages()->create([
                'package_id'    => $package->id,
                'has_offer'    => $orderPackage['off'] ? true : false,
                'offer_price'    => $orderPackage['off'],
                'total'    => $orderPackage['total'],
                'period'    => $packagePrice->days_count,
                'settings'    => $package->settings,
            ]);
        }
    }


    public function orderEvent($order, $event)
    {
        $orderCourse = $order->orderCourses()->create([
            'course_id' => $event['id'],
            'total' => $event['price'],
        ]);
    }

    public function update($id, $boolean)
    {
        $order = $this->findById($id);

        $status = $this->statusOfOrder($boolean);

        $order->update([
            'is_hold' => false,
            'order_status_id' => $status['id']
        ]);

        $this->updateCoursePeriod($order);
        $this->updatePackagePeriod($order);

        return $order;
    }

    private function updateCoursePeriod($order): void
    {
        foreach ($order->orderCourses()->get() as $orderCourse) {
            $course = $orderCourse->course;

            if ($course->period) :
                $orderCourse->update([
                    'period' => $course->period,
                    'expired_date' => Carbon::now()->addDays($course->period)->toDateTimeString(),
                ]);
            endif;

            $this->notify($orderCourse);
        }
    }

    private function updatePackagePeriod($order): void
    {
        foreach ($order->orderPackages()->get() as $orderPackage) {
            $orderPackage->update([
                'expired_date' => Carbon::now()->addDays($orderPackage->period)->toDateTimeString(),
            ]);
        }
    }

    public function statusOfOrder($type)
    {
        if ($type == 1) {
            $status = $this->status->successPayment()->first();
        }else if($type == 2){
            $status = $this->status->failedOrderStatus()->first();
        }else if ($type == 3) {
            $status = $this->status->pendingOrderStatus()->first();
        }
        return $status;
    }


    public function BuySingleCourseForTestAccount($userID, $course)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(1);

            $order = $this->order->create([
                'is_holding' => false,
                'discount' => 0.000,
                'subtotal' => $course->price,
                'total' => $course->price,
                'user_id' => $userID,
                'order_status_id' => $status->id,
            ]);

            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $course->price,
                'trainer_id'   => $course->trainer_id,
                'user_id'      => $userID,
                'expired_date' => $course->extra_attributes->get('end_date', null),
            ]);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function removeOrderAndOrderCourses( $order)
    {
        DB::beginTransaction();

        try {
            $order->delete();
            $order->orderCourses()->delete();
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function notify(OrderCourse $orderCourse): void
    {
        // $orderCourse->user->notify(new NewCourseEnrollmentNotification($orderCourse->course));
    }
}
