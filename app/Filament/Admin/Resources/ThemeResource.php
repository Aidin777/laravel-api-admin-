<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ThemeResource\Pages;
use App\Filament\Admin\Resources\ThemeResource\RelationManagers;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThemeResource extends Resource
{
    protected static ?string $model = Theme::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Уроки';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Тему';
    protected static ?string $pluralModelLabel = 'Темы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Тема вселенной')->schema([
                    TextInput::make('title')
                        ->required()
                        ->label('Тайтл'),
                    TextInput::make('slug')
                        ->required()
                        ->label('Технический заголовок')
                        ->unique(ignoreRecord:true)
                        ->placeholder('ТОЛЬКО НА АНГЛИЙСКОМ!!'),
                    TextInput::make('short_description')
                        ->required()
                        ->label('Краткое описание внутри вселенной'),
                    Select::make('category')
                        ->label('Предмет')
                        ->options(['Русский язык' => 'Русский язык']),
                    TextInput::make('description')
                        ->required()
                        ->label('Описание темы')
                        ->columnSpan(['md' => 2, 'xl' => 3]),
                    FileUpload::make('thumbnail')
                        ->required()
                        ->label('Превью темы')
                        ->columnSpan(['md' => 2, 'xl' => 3]),
                ])->columns(['md' => 2, 'xl' => 3]),
                Section::make('Настройка градиента бекграунда вселенной')
                ->description('Лучше настраивать в соответствие с рекомендациями фронтендера или дизайнера')
                ->schema([
                    TextInput::make('grad_radius')
                        ->label('Угол градиента'),
                    ColorPicker::make('grad_color_1')
                        ->label('Цвет 1'),
                    ColorPicker::make('grad_color_2')
                        ->label('Цвет 2'),
                ])->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('thumbnail')
                    ->label('Превью'),
                TextColumn::make('category')
                    ->label('Предмет'),
                TextColumn::make('title')
                    ->label('Тема'),
                TextColumn::make('description')
                    ->limit(30)
                    ->label('Описание'),
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
            'index' => Pages\ListThemes::route('/'),
            'create' => Pages\CreateTheme::route('/create'),
            'edit' => Pages\EditTheme::route('/{record}/edit'),
        ];
    }
}
