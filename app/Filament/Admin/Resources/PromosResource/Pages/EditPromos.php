<?php

namespace App\Filament\Admin\Resources\PromosResource\Pages;

use App\Filament\Admin\Resources\PromosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromos extends EditRecord
{
    protected static string $resource = PromosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
