<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LessonTestResource\Pages;
use App\Filament\Admin\Resources\LessonTestResource\RelationManagers;
use App\Models\Lesson;
use App\Models\LessonTest;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonTestResource extends Resource
{
    protected static ?string $model = LessonTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Уроки';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Тест';
    protected static ?string $pluralModelLabel = 'Тесты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Section::make([
                        Select::make('lesson_id')
                            ->label('Занятие')
                            ->required()
                            ->options(Lesson::all()->pluck('title', 'id'))
                            ->searchable(),
                    ]),
                Builder::make('content')->blocks([

                    Builder\Block::make('questionBlock_5a')->schema([
                        TextInput::make('question')->label('Вопрос'),
                        Section::make('Текст')->schema([
                            RichEditor::make('text')->label('Текст'),
                            Toggle::make('have_text')->label('Есть текст в вопросе?'),
                        ])->collapsed(),
                        Section::make('Объяснение')->schema([
                            RichEditor::make('explanation_text')->label('Текст'),
                            Toggle::make('have_explanation')->label('Есть  в вопросе?'),
                        ])->collapsed(),
                        Section::make('Вариант 1')->schema([
                            TextInput::make('answer_1')->label('Ответ'),
                            Toggle::make('isCorrect_1')->label('Правильный?'),
                        ]),
                        Section::make('Вариант 2')->schema([
                            TextInput::make('answer_2')->label('Ответ'),
                            Toggle::make('isCorrect_2')->label('Правильный?'),
                        ]),
                        Section::make('Вариант 3')->schema([
                            TextInput::make('answer_3')->label('Ответ'),
                            Toggle::make('isCorrect_3')->label('Правильный?'),
                        ]),
                        Section::make('Вариант 4')->schema([
                            TextInput::make('answer_4')->label('Ответ'),
                            Toggle::make('isCorrect_4')->label('Правильный?'),
                        ]),
                        Section::make('Вариант 5')->schema([
                            TextInput::make('answer_5')->label('Ответ'),
                            Toggle::make('isCorrect_5')->label('Правильный?'),
                        ]),
                    ])->label('Вопрос с 5 вариантами ответа'),

                    Builder\Block::make('questionBlock_Oa')->schema([
                        Section::make('Текст')->schema([
                            RichEditor::make('text')->label('Текст'),
                            Toggle::make('have_text')->label('Есть текст в вопросе?'),
                        ])->collapsible(),
                        Section::make('Объяснение')->schema([
                            RichEditor::make('explanation_text')->label('Текст'),
                            Toggle::make('have_explanation')->label('Есть  в вопросе?'),
                        ])->collapsed(),
                        TextInput::make('question')->label('Вопрос'),
                        TextInput::make('choice')->label('Ответ'),

                    ])->label('Вопрос с одним ответом')
                ])->columnSpan(2)
                ->collapsed()
                ->deletable(false)
                ->label('Контент теста')
                ,
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
                TextColumn::make('id')
                    ->label('Номер теста')
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
            'index' => Pages\ListLessonTests::route('/'),
            'create' => Pages\CreateLessonTest::route('/create'),
            'edit' => Pages\EditLessonTest::route('/{record}/edit'),
        ];
    }
}
