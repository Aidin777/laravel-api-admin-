<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PromosResource\Pages;
use App\Filament\Admin\Resources\PromosResource\RelationManagers;
use App\Models\Promos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromosResource extends Resource
{
    protected static ?string $model = Promos::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Пользователи';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Промокод';
    protected static ?string $pluralModelLabel = 'Промокоды';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.phone')
                    ->label('Телефон'),
                TextColumn::make('counter')
                    ->label('Кол-во использований')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('counter')
                    ->label('Обнулить счетчик')
                    ->requiresConfirmation()
                    ->action(fn (Promos $record) => $record->update(['counter' => 0]))
                    ->color('info'),
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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromos::route('/create'),
            'edit' => Pages\EditPromos::route('/{record}/edit'),
        ];
    }
}
