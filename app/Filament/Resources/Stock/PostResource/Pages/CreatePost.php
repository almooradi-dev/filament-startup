<?php

namespace App\Filament\Resources\Stock\PostResource\Pages;

use App\Filament\Resources\Stock\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = PostResource::class;
}
