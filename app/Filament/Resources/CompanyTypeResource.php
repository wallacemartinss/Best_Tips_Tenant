<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CompanyType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyTypeResource\Pages;
use App\Filament\Resources\CompanyTypeResource\RelationManagers;
use App\Filament\Resources\CompanyTypeResource\RelationManagers\LabortaxesRelationManager;
use App\Filament\Resources\CompanyTypeResource\RelationManagers\SocialTaxesRelationManager;

class CompanyTypeResource extends Resource
{
    protected static ?string $model = CompanyType::class;

    protected static ?string $navigationIcon = 'fas-file-invoice-dollar';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Regime Tributário';
    protected static ?string $modelLabel = 'Regime Tributário';
    protected static ?string $modelLabelPlural = "Regimes tributários";
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
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
            LabortaxesRelationManager::class,
            SocialTaxesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyTypes::route('/'),
            'create' => Pages\CreateCompanyType::route('/create'),
            'edit' => Pages\EditCompanyType::route('/{record}/edit'),
        ];
    }
}
