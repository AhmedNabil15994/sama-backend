<?php

namespace Modules\Course\Transformers\Trainer;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewQuestionResource extends JsonResource
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
            'id'            => $this->id,
            'course'            => $this->course->title,
            'course_slug'            => $this->course->slug,
            'user'            => $this->user?->name?? $this->user?->mobile,
            'question'         => $this->question,
            'lesson_content_id'         => $this->lesson_content_id,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
