<?php
use Illuminate\Support\Str;


function getVideoName( $video, $ext = null )
{
   $videoName =  $ext
                ? $video->description.'_'.$video->id.'.'.$ext
                :  $video->description.'_'.$video->id;
    return Str::lower(str_replace(' ','_', $videoName ) );
}

function getVideoNameCorrection( $video, $ext = null )
{
   $videoName =  $ext
                ? $video->description.'_'.$video->id.'.'.$ext
                :  $video->description.'_'.$video->id;
    return Str::lower(str_replace(' ','_', $videoName ) );
}

function getThumbnailName(string $name, int $id, ?string $ext = NULL) : string
{
    $fileName =  $name.'_'.$id.'.';
    $thumb =  $ext ? $fileName .$ext : $fileName;
    return Str::lower(str_replace(' ','_', $thumb ) );
}
