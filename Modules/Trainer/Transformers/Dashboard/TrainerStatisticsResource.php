<?php

namespace Modules\Trainer\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainerStatisticsResource extends JsonResource
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
           'name'                           => $this->name,
           'order_courses_profit'         => $this->order_courses_profit,
           'order_notes_profit'        => $this->order_notes_profit,
       ];
    }
}
