<?php

namespace App\Filament\Admin\Resources\PresentationResource\Pages;

use App\Filament\Admin\Resources\PresentationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresentation extends EditRecord
{
    protected static string $resource = PresentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
