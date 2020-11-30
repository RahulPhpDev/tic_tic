<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MusicResponse extends JsonResource
{
    public static $wrap = "msg";
//
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $res = $this->favorites->transform( function ($data) {
               return [
                "id" => $data->id,
                "audio_path" => [
                    "mp3" => $data->mp3_path,
                    "acc" => $data->aac_path
                ],
                "sound_name" => $data->name,
                "description" => $data->description,
                "section" => \App\Models\Section::find($data->section_id)->name,
                "thum" => $data->thumb,
                "created" => $data->created_at,

               ];

        });

       return $res->toArray();
    }
}
