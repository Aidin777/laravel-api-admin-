<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PresentationResource\Pages;
use App\Filament\Admin\Resources\PresentationResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Presentation;
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

class PresentationResource extends Resource
{
    protected static ?string $model = Presentation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Уроки';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Презентацию';
    protected static ?string $pluralModelLabel = 'Презентации';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('link'),
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
            'index' => Pages\ListPresentations::route('/'),
            'create' => Pages\CreatePresentation::route('/create'),
            'edit' => Pages\EditPresentation::route('/{record}/edit'),
        ];
    }
}
