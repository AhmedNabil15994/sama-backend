<?php

namespace Modules\Exam\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class UserExamResource extends JsonResource
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
                'user_id'       => $this->user->name,
                'exam_id'       => $this->exam->title,
                'course'        => $this->exam?->course?->title,
                'trainer'        => $this->exam?->trainer?->name,
                'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
