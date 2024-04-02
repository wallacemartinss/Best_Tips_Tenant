<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departament;
use App\Models\WorkContract;
use Filament\Facades\Filament;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\BulkActionGroup;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Tables\Actions\DeleteBulkAction;
use Leandrocfe\FilamentPtbrFormFields\Document;
use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\Pages\EditEmployee;
use App\Filament\App\Resources\EmployeeResource\Pages\ListEmployees;
use App\Filament\App\Resources\EmployeeResource\Pages\CreateEmployee;

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
               
                Document::make('document_number')
                    ->label('CNPJ ou CPF do prestador de serviço/Colaborador ')
                    ->dynamic()
                    ->validation(false)
                    ->required(),

                TextInput::make('frist_name')
                    ->label('Primeiro Nome')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->label('Último Nome')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('brith_date')
                    ->label('Data de nascimento'),

                DatePicker::make('admission_date')
                    ->label('Data de admissão')
                    ->required(),

                TextInput::make('jorney_work')
                    ->label('Carga Hora')
                    ->required(),
                Money::make('salary')
                    ->label('Salário')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('departament.name')
                    ->label('Departamento')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('work_contract.name')
                    ->label('Contrato de Trabalho')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('document_number')
                    ->label('CPF')
                    ->searchable(),
                TextColumn::make('frist_name')
                    ->label('Primeiro Nome')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Último Nome')
                    ->searchable(),
                TextColumn::make('jorney_work')
                    ->label('Carga Hora'),
                TextColumn::make('salary')
                    ->label('Salário')
                    ->money('brl')
                    ->sortable(),
                TextColumn::make('brith_date')
                    ->label('Data de nascimento')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('admission_date')
                    ->label('Data de admissão')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
