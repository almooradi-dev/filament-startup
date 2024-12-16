<?php

namespace App\Filament\Resources\Stock\PostCollectionResource\Pages;

use App\Filament\Resources\Stock\PostCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostCollection extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = PostCollectionResource::class;
}
