<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuestionResource\Pages;
use App\Filament\Admin\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Вопросы для дуэлей';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Вопрос';
    protected static ?string $pluralModelLabel = 'Вопросы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('theme')
                    ->options([
                        'Ударения' => 'Ударения',
                        '“Ъ” или “Ь”' => '“Ъ” или “Ь”',
                        'Приставки' => 'Приставки',
                        'Корни' => 'Корни',
                        'Суффиксы и окончания' => 'Суффиксы и окончания',
                        '“Н” или “НН”' => '“Н” или “НН”',
                        'Числительные' => 'Числительные'
                    ])
                    ->label('Тема')
                    ->placeholder('Тема вопроса')
                    ->required(),
                TextInput::make('question')
                    ->label('Вопрос')
                    ->placeholder('Вопрос')
                    ->required(),
                Builder::make('answers')->blocks([
                    Builder\Block::make('answer')->schema([
                        TextInput::make('answerText')->label('Ответ'),
                        Toggle::make('boolean')->label('Правильный вариант?'),
                        TextInput::make('numeric')->label('Техническое поле')->placeholder('Если ответ верный, то введите 1, если нет, то 0')->default(0)->hidden(),
                    ])->label('Ответ')->columns(['md' => 1, 'xl' => 2])
                ])->columnSpan(2)
                    ->addActionLabel('Добавить вариант')
                    ->maxItems(2)
                    ->minItems(2)
                    ->required()
                    ->label('Варианты ответов'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('theme')->label('Тема'),
                Tables\Columns\TextColumn::make('question')->label('Вопрос'),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
