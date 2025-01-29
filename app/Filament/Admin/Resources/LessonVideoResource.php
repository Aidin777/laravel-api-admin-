<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LessonVideoResource\Pages;
use App\Filament\Admin\Resources\LessonVideoResource\RelationManagers;
use App\Models\Lesson;
use App\Models\LessonVideo;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonVideoResource extends Resource
{
    protected static ?string $model = LessonVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationGroup = 'Уроки';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Видео';
    protected static ?string $pluralModelLabel = 'Видео';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('link')
                    ->maxSize(100000000),
                Select::make('lesson_id')
                    ->label('Урок')
                    ->required()
                    ->options(Lesson::all()->pluck('title', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson.theme.title')
                    ->label('Вселенная')
                    ->searchable(),
                TextColumn::make('lesson.title')
                    ->label('Занятие')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessonVideos::route('/'),
            'create' => Pages\CreateLessonVideo::route('/create'),
            'edit' => Pages\EditLessonVideo::route('/{record}/edit'),
        ];
    }
}
