<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Models\Departament;
use App\Models\WorkContract;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'fas-user-tie';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $navigationLabel = 'Funcionários';
    protected static ?string $modelLabel = 'Funcionário';
    protected static ?string $modelLabelPlural = "Funcionários";
    protected static ?int $navigationSort = 3;
    protected static bool $isScopedToTenant = true;

    public static function form(Form $form): Form
    {
        $tenant = Filament::getTenant();
        $tenant = $tenant->id;
        
        return $form

            ->schema([
                Select::make('company_id')
                    ->label('Minha Empresa')
                    ->options(Company::where('organization_id', $tenant)->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),

                Select::make('departament_id')
                    ->label('Departamento')
                    ->options(Departament::where('organization_id', $tenant)->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),


                Select::make('work_contract_id')
                    ->label('Contrato de Trabalho')
                    ->options(WorkContract::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
               
                Forms\Components\TextInput::make('document_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('frist_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('brith_date'),
                Forms\Components\DatePicker::make('admission_date')
                    ->required(),
                Forms\Components\TextInput::make('jorney_work')
                    ->required(),
                Forms\Components\TextInput::make('salary')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('departament.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_contract.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frist_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brith_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('admission_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jorney_work'),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
