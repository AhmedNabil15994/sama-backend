<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCoursesResource extends JsonResource
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
            'id' => $this->id ,
            'username' => $this->user->name ,
            'mobile' => $this->user->mobile ,
            'course_name' => $this->orderCourses && isset($this->orderCourses[0]) ? $this->orderCourses[0]->course->title : '' ,
            'created_at' => date('d-m-Y' , strtotime($this->created_at)) ,
            'expired_date' => $this->orderCourses ? (isset($this->orderCourses[0]) ? $this->orderCourses[0]->expired_date_format : '') : '' ,
            'subtotal' => $this->subtotal ,
            'total' => $this->total ,
        ];
    }
}
