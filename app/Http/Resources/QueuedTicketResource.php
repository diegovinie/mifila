<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class QueuedTicketResource extends Resource
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
            'num'=> $this->num,
            'client' => new LightClientResource($this->client),
            'noti' => $this->notificable,
        ];
    }
}
