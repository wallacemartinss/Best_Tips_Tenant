<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkContractResource\Pages;
use App\Models\WorkContract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkContractResource extends Resource
{
    protected static ?string $model = WorkContract::class;

    protected static ?string $navigationIcon = 'fas-file-contract';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Contratos de Trabalho';
    protected static ?string $modelLabel = 'Contrato de Trabalho';
    protected static ?string $modelLabelPlural = "Contratos de Trabalho";
    protected static ?int $navigationSort = 5;
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descricão')
                    ->maxLength(255),
                Forms\Components\Toggle::make('active')
                    ->label('Ativo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWorkContracts::route('/'),
        ];
    }
}
