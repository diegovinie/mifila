<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LightAgencyResource extends Resource
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
            'info' => $this->info,
            'cashiers' => LightCashierResource::collection($this->cashiers)
        ];
    }
}
