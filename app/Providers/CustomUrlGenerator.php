<?php

namespace App\Providers;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;
use Spatie\MediaLibrary\Support\UrlGenerator\UrlGenerator;

class CustomUrlGenerator extends DefaultUrlGenerator implements UrlGenerator
{
    public function getPathRelativeToRoot(): string
    {
        dd($this->pathGenerator->getPath($this->media));
        if (is_null($this->conversion)) {
            return $this->pathGenerator->getPath($this->media).($this->media->file_name);
        }
        return $this->pathGenerator->getPathForConversions($this->media)
                .$this->conversion->getConversionFile($this->media);
    }
}
