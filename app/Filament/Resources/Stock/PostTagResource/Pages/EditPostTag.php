<?php

namespace App\Filament\Resources\Stock\PostTagResource\Pages;

use App\Filament\Resources\Stock\PostTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostTag extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PostTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
