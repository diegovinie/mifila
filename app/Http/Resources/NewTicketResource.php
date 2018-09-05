<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NewTicketResource extends Resource
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
            'num' => $this->num,
            'client' => [
                'name' => $this->client->name,
            ],
            'agency' => [
                'name' => $this->agency->name,
            ],
            // 'queue' => $this->agency->info->queue,
            'created' => $this->created_at,
        ];
    }
}
