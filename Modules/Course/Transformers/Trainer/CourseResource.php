<?php

namespace Modules\Course\Transformers\Trainer;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Dashboard\CategoryResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'categories'   => CategoryResource::collection($this->categories),
            'trainer_id'   => $this->trainer?->name,
            'price'        => $this->price,
            'class_time'   => $this->class_time,
            'order'         => $this->order,
            'created_at'   => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
