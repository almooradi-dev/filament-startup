<?php

namespace App\Filament\Resources\Stock\PostTagResource\Pages;

use App\Filament\Resources\Stock\PostTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostTags extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PostTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
