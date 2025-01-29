<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LessonResource\Pages;
use App\Filament\Admin\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Theme;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Уроки';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Занятие';
    protected static ?string $pluralModelLabel = 'Занятия';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('theme_id')
                    ->label('Тема')
                    ->required()
                    ->options(Theme::all()->pluck('title', 'id')),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->placeholder('Заголовок для занятия')
                    ->required(),
                TextInput::make('description')
                    ->label('Описание')
                    ->placeholder('Описание занятия')
                    ->required(),
                TextInput::make('short_description')
                    ->label('Короткое описание')
                    ->placeholder('Короткое описание занятия')
                    ->required(),
                TextInput::make('slug')
                    ->label('Технический заголовок')
                    ->placeholder('ТОЛЬКО НА АНГЛИЙСКОМ!! Технический заголовок для занятия')
                    ->required(),



                Section::make('Стилизация')->schema([
                    FileUpload::make('thumbnail')
                    ->label('Превью Урока')
                    ->columnSpan(1),
                    FileUpload::make('card_background')
                    ->label('Фон карточки')
                    ->columnSpan(1),
                    ColorPicker::make('gradient_color_1')->label('1 цвет градиента кнопки'),
                    ColorPicker::make('gradient_color_2')->label('2 цвет градиента кнопки'),
                    ColorPicker::make('gradient_color_3')->label('3 цвет градиента кнопки'),
                ])->collapsed()->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('theme.title')
                    ->label('Вселенная')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Заголовок'),
                TextColumn::make('description')
                    ->limit(25)
                    ->label('Описание занятия'),
                TextColumn::make('')
                    ->label(''),
                ToggleColumn::make('is_free')
                    ->label('Бесплатный?'),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
