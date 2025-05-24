<?php

namespace Modules\Course\Transformers\Trainer;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $columns = [
            'id'            => $this->id,
            'title'         => $this->title,
            'course_id'     => $this->lesson?->course?->title,
            'lesson_id'     => $this->lesson?->title,
            'type'          => __('course::dashboard.lessoncontents.datatable.' . $this->type),
            'deleted_at'    => $this->deleted_at,
            'order'         => $this->order,
            'is_free'       => $this->is_free ? __('course::dashboard.lessoncontents.form.yes') : __('course::dashboard.lessoncontents.form.no'),
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
        return $columns;
    }
}
