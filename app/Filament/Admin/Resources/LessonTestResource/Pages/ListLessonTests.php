<?php

namespace App\Filament\Admin\Resources\LessonTestResource\Pages;

use App\Filament\Admin\Resources\LessonTestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessonTests extends ListRecords
{
    protected static string $resource = LessonTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
