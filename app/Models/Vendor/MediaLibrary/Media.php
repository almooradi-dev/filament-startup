<?php

namespace App\Models\Vendor\MediaLibrary;

use App\Services\Vendor\MediaLibrary\UrlGeneratorFactory;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    public function getUrl(string $conversionName = ''): string
    {
        $urlGenerator = UrlGeneratorFactory::createForMedia($this, $conversionName);

        return $urlGenerator->getUrl();
    }
}
