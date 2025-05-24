<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseCardResource extends JsonResource
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
            'category'  => $this->category?->title,
            'image'        => asset($this->image),
            'User_complete_percentage'        => $this->User_complete_percentage,
            'intro_url'        => $this->intro_video,
            'intro_url_web_view'        => route("api.run.video",[$this->id,'course_intro']),
            'is_favourite'        => $this->is_favourite,
            'has_exams'        => $this->exams_count > 0 ? true : false,
            'has_resources'        => $this->resources_count > 0 ? true : false,
            'is_subscribed'        => $this->current_user_has_access,
            'price'        => number_format($this->price,3),
            'apple_price'        => number_format($this->apple_price,3),
            'sub_title'      => __('By') . ' ' . $this->trainer?->name,
        ];
    }
}
