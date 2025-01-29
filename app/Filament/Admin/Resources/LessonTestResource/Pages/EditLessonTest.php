<?php

namespace App\Filament\Admin\Resources\LessonTestResource\Pages;

use App\Filament\Admin\Resources\LessonTestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLessonTest extends EditRecord
{
    protected static string $resource = LessonTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
