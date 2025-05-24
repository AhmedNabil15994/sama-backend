<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPackagesResource extends JsonResource
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
            'package_name' => $this->orderPackages && isset($this->orderPackages[0]) ? $this->orderPackages[0]->package->title : '' ,
            'created_at' => date('d-m-Y' , strtotime($this->created_at)) ,
            'expired_date' => $this->orderPackages ? (isset($this->orderPackages[0]) ? $this->orderPackages[0]->expired_date_format : '') : '' ,
            'subtotal' => $this->subtotal ,
            'total' => $this->total ,
        ];
    }
}
