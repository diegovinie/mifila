<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LightCashierResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rate' => $this->rate,
            'active' => $this->active,
            'current' =>$this->current
        ];
    }
}
