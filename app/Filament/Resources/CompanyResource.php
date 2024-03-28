<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Document;
use App\Filament\Resources\CompanyResource\Pages;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use App\Filament\Resources\CompanyResource\RelationManagers\CompanyAddressRelationManager;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'fas-building';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Empresas';
    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $modelLabelPlural = "Empresas";
    protected static ?int $navigationSort = 3;
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('organization_id')
                    ->label('Tenant')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('company_type_id')
                    ->label('Tipo de Empresa')
                    ->relationship('company_type', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Razão Social')
                    ->required()
                    ->maxLength(255),
                TextInput::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->maxLength(255),
                Document::make('document_number')
                    ->label('CNPJ da Empresa ou CPF caso não tenha CNPJ')
                    ->dynamic()
                    ->validation(false)
                    ->required(),
                PhoneNumber::make('phone_number')
                ->label('Telefone')
                        ->format('(99)99999-9999')
                ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Tenant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('company_type.name')
                    ->label('Tipo de Empresa')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Razão Social')
                    ->searchable(),
                TextColumn::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->searchable(),
                TextColumn::make('document_number')
                    ->label('Número de DOcumento')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Telefone')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
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
            CompanyAddressRelationManager::class,
              
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
