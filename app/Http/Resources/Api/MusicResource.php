<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MusicResource extends JsonResource
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
            "id" => $this->id,
            "audio_path" => [
                "mp3" => $this->mp3_path,
                "acc" => $this->aac_path
            ],
            "sound_name" => $this->name,
            "description" => $this->description,
            "section" =>  $this->whenLoaded('section'),
            // $this->mergeWhen($this->favorites_count, [
            //     'favorites_count' => $this->favorites_count
            // ]),
            'favorites_count' => $this->when($this->favorites_count, $this->favorites_count),
            "thum" => $this->thumb,
            "created" => $this->created_at
        ];
    }
}
