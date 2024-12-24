<?php

namespace App\Services\Vendor\MediaLibrary;

use Spatie\MediaLibrary\Conversions\ConversionCollection;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidUrlGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;
use Spatie\MediaLibrary\Support\UrlGenerator\UrlGenerator;


/**
 * https://github.com/spatie/laravel-medialibrary/issues/2123
 */
class UrlGeneratorFactory extends \Spatie\MediaLibrary\Support\UrlGenerator\UrlGeneratorFactory
{
    public static $cache = [];

    public static function createForMedia(Media $media, string $conversionName = ''): UrlGenerator
    {
        $urlGeneratorClass = config('media-library.url_generator');

        static::guardAgainstInvalidUrlGenerator($urlGeneratorClass);

        /** @var \Spatie\MediaLibrary\Support\UrlGenerator\UrlGenerator $urlGenerator */
        $urlGenerator = app($urlGeneratorClass);

        $pathGenerator = PathGeneratorFactory::create($media);

        $urlGenerator
            ->setMedia($media)
            ->setPathGenerator($pathGenerator);

        if ($conversionName !== '') {
            $conversions = static::getConversions($media);

            $conversion = $conversions->getByName($conversionName);

            $urlGenerator->setConversion($conversion);
        }

        return $urlGenerator;
    }

    public static function getConversions(Media $media): ConversionCollection
    {
        if (array_key_exists($media->uuid, static::$cache)) {
            return static::$cache[$media->uuid];
        }

        $conversions = ConversionCollection::createForMedia($media);
        static::$cache[$media->uuid] = $conversions;

        return $conversions;
    }

    public static function guardAgainstInvalidUrlGenerator(string $urlGeneratorClass): void
    {
        if (! class_exists($urlGeneratorClass)) {
            throw InvalidUrlGenerator::doesntExist($urlGeneratorClass);
        }

        if (! is_subclass_of($urlGeneratorClass, UrlGenerator::class)) {
            throw InvalidUrlGenerator::doesNotImplementUrlGenerator($urlGeneratorClass);
        }
    }
}
