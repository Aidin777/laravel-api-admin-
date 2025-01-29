<?php

namespace App\Filament\Admin\Resources\LessonVideoResource\Pages;

use App\Filament\Admin\Resources\LessonVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessonVideos extends ListRecords
{
    protected static string $resource = LessonVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
