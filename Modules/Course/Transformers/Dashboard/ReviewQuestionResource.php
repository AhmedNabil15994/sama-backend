<?php

namespace Modules\Course\Transformers\Dashboard;

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
        $course_title = $this->course ? $this->course->title : "Go To";
        return [
            'id'            => $this->id,
            'title'         => $this->question,
            'course'         => $this->course ? $this->course->title : '',
            'link'         => '<a target="_blank" href="'. route('frontend.courses.show', $this->course->slug) . '?lesson-content-id=' . $this->lesson_content_id .'">'. $course_title .'</a>',
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
