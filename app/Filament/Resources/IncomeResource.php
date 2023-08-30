<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Mongo\Income;
use App\Models\Mysql\Account;
use App\Models\Mysql\Card;
use App\Models\Mysql\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

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
                    ->options(Category::where('reference', 'income')->get()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('account_id')
                    ->label('Conta')
                    ->placeholder('Selecione uma conta')
                    ->options(Account::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => auth()->user()->id),
                Forms\Components\Hidden::make('type')
                    ->default('expense'),
            ]);
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
