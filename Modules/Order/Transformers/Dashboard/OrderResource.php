<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id'                   => $this->id,
           'subtotal'             => $this->subtotal,
           'discount'             => $this->discount,
           'total'                => $this->total,
           'username'             => $this->user->name,
           'mobile'               => $this->user->mobile,
           'email'                => $this->user->email,
           'order_status_id'      => $this->orderStatus->title,
           'package_name'         => $this->orderPackages && isset($this->orderPackages[0]) ? $this->orderPackages[0]->package->title : '',
           'deleted_at'           => $this->deleted_at,
           'expired_date'           => $this->orderPackages ? (isset($this->orderPackages[0]) ? $this->orderPackages[0]->expired_date_format : '') : '',
           'expired_course_date'           => $this->orderCourses ? (isset($this->orderCourses[0]) ? $this->orderCourses[0]->expired_date_format : '') : '',
           'created_at'           => date('d-m-Y', strtotime($this->created_at)),
       ];
    }
}
