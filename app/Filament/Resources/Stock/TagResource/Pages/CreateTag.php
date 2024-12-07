<?php

namespace App\Filament\Resources\Stock\TagResource\Pages;

use App\Filament\Resources\Stock\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = TagResource::class;
}
