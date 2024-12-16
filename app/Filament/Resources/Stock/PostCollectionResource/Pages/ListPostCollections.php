<?php

namespace App\Filament\Resources\Stock\PostCollectionResource\Pages;

use App\Filament\Resources\Stock\PostCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostCollections extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PostCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
