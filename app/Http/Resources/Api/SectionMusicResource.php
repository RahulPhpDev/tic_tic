<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SectionMusicResource extends ResourceCollection
{
    public static $wrap = 'msg';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return $this->collection->transform( function ($section) {

            $sectionsSounds = [];
            $section->music->each( function ($music) use ($section, &$sectionsSounds) {
                $sectionsSounds[] = [
                    "id" =>  $music->id,
                    "audio_path" => [
                        "mp3" => $music->mp3_path,
                        "acc" => $music->aac_path,
                    ],
                    "sound_name" => $music ->name,
                    "description" => $music ->description,
                    "section" => $section->name,
                    "thum" => $music->thumb,
                    "favourite_status" => $music->favorites->isNotEmpty() ? TRUE : FALSE,
                    "created" =>  $music->created_at
                ];
            });
            return [
                'section_name' => $section->name,
                'sections_sounds' => $sectionsSounds
            ];
        });
    }
}
