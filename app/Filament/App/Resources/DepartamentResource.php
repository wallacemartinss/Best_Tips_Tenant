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
use App\Filament\App\Resources\DepartamentResource\Pages;

class DepartamentResource extends Resource
{
    protected static ?string $model = Departament::class;
    protected static ?string $navigationIcon = 'fas-building-user';
    protected static ?string $navigationGroup = 'Configurações';
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

                Select::make('company_id')
                    ->label('Minha Empresa')
                    ->options(Company::where('organization_id', $tenant)->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('name')
                    ->label('Tipo de Setor')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('description')
                    ->label('Descrição do Setor')
                    ->maxLength(255),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               
                Tables\Columns\TextColumn::make('sector.name')
                    ->numeric()
                    ->sortable(),
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
