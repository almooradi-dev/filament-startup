<?php

namespace App\Filament\Resources\Stock\CollectionResource\Pages;

use App\Filament\Resources\Stock\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCollection extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;
}
