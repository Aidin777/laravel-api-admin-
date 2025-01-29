<?php

namespace App\Filament\Admin\Resources\PresentationResource\Pages;

use App\Filament\Admin\Resources\PresentationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresentations extends ListRecords
{
    protected static string $resource = PresentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
