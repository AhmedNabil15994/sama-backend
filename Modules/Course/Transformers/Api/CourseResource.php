<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'category'  => $this->category?->title,
            'User_complete_percentage'        => $this->User_complete_percentage,
            'image'        => asset($this->image),
            'intro_url'        => $this->intro_video,
            'intro_url_web_view'        => route("api.run.video",[$this->id,'course_intro']),
            'is_favourite'        => $this->is_favourite,
            'has_exams'        => $this->exams_count > 0 ? true : false,
            'has_resources'        => $this->resources_count > 0 ? true : false,
            'has_questions'        => $this->review_questions_count > 0 ? true : false,
            'is_subscribed'        => $this->current_user_has_access,
            'price'        => number_format($this->price,3),
            'apple_price'        => number_format($this->apple_price,3),
            'sub_title'      => __('By') . ' ' . $this->trainer?->name,
            'short_desc'        => $this->short_desc,
            'description'        => $this->description,
            'requirements'        => $this->requirements,
        ];
    }
}
