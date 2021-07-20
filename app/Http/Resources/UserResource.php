<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            '_status' => 200,
            'data' => ['name' => $this->name, 'access_token' => $this->token],
            '_message' => 'success authentication',
            '_url' => $request->url(),
            '_method' => $request->method(),
        ];
    }
}
