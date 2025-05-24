<?php

namespace Modules\Exam\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'id'         => $this->id,
            'answer'      => $this->answer,
            'is_correct'      => $this->is_correct ? true : false,
            'image'            => $this->image
        ];
    }
}
