<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sector;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departament;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\App\Resources\DepartamentResource\Pages;

class DepartamentResource extends Resource
{
    protected static ?string $model = Departament::class;
    protected static ?string $navigationIcon = 'fas-building-user';
    protected static ?string $navigationGroup = 'Mão de Obra';
    protected static ?string $navigationLabel = 'Departamentos';
    protected static ?string $modelLabel = 'Departamento';
    protected static ?string $modelLabelPlural = "Departamentos";
    protected static ?int $navigationSort = 2;
    protected static bool $isScopedToTenant = true;

    public static function form(Form $form): Form
    {

        $tenant = Filament::getTenant();
        $tenant = $tenant->id;

        return $form
            ->schema([
           
                Select::make('sector_id')
                    ->label('Tipo de Setor')
                    ->options(Sector::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label('Tipo de Setor')
                    ->required()
                    ->maxLength(255),

                TextInput::make('description')
                    ->label('Descrição do Setor')
                    ->maxLength(255),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               
                TextColumn::make('sector.name')
                    ->label('Tipo de Setor')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nome do Setor')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Descrição do Setor')
                    ->searchable(),
                ToggleColumn::make('active')
                    ->label('Ativo'),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDepartaments::route('/'),
            'create' => Pages\CreateDepartament::route('/create'),
            'edit' => Pages\EditDepartament::route('/{record}/edit'),
        ];
    }
}
