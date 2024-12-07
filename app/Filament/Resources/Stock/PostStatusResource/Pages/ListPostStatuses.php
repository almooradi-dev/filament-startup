<?php

namespace App\Filament\Resources\Stock\PostStatusResource\Pages;

use App\Filament\Resources\Stock\PostStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostStatuses extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PostStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
