<?php

namespace App\Filament\Resources\Stock\PostTypeResource\Pages;

use App\Filament\Resources\Stock\PostTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostType extends CreateRecord
{
    protected static string $resource = PostTypeResource::class;
}
