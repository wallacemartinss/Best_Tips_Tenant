<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Money;
use App\Filament\Resources\PlanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Filament\Resources\PlanResource\RelationManagers\DetailplanRelationManager;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationIcon = 'fas-file-signature';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Planos';
    protected static ?string $modelLabel = 'Plano';
    protected static ?string $modelLabelPlural = "Planos";
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome do Plano')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                Select::make('duration')
                    ->options([
                        'Mensal' => 'Mensal',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                    ]),
                Money::make('value')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome do Plano')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                ToggleColumn::make('active'),
                TextColumn::make('value')
                    ->numeric()
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('duration')
                    ->label('Duração')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            DetailplanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
            'create' => Pages\CreatePlan::route('/create'),
        ];
    }
}
