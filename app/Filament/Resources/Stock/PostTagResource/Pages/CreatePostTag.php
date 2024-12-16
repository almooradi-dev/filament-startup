<?php

namespace App\Filament\Resources\Stock\PostTagResource\Pages;

use App\Filament\Resources\Stock\PostTagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostTag extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = PostTagResource::class;
}
