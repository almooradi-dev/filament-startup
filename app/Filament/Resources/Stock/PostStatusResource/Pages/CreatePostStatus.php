<?php

namespace App\Filament\Resources\Stock\PostStatusResource\Pages;

use App\Filament\Resources\Stock\PostStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostStatus extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = PostStatusResource::class;
}
