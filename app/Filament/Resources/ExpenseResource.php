<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Mongo\Expense;
use App\Models\Mysql\Account;
use App\Models\Mysql\Card;
use App\Models\Mysql\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('amount')
                    ->label('Valor')
                    ->prefix('R$')
                    ->required()
                    ->inputMode('decimal')
                    ->maxValue(42949672.95),
                TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                Select::make('category_id')
                    ->label('Categoria')
                    ->placeholder('Selecione uma categoria')
                    ->options(Category::where('reference', 'expense')->get()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('account_id')
                    ->label('Conta')
                    ->placeholder('Selecione uma conta')
                    ->options(Account::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('card_id')
                    ->label('Cartão')
                    ->placeholder('Selecione um cartão')
                    ->options(Card::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => auth()->user()->id),
                Forms\Components\Hidden::make('type')
                    ->default('expense'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Conta'),
                TextColumn::make('card.name')
                    ->label('Cartão')
                    ->badge()
                    ->color(fn (string $state): string => 'danger'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria'),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
