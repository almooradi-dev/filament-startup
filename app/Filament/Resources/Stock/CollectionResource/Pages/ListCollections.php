<?php

namespace App\Filament\Resources\Stock\CollectionResource\Pages;

use App\Filament\Resources\Stock\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollections extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
