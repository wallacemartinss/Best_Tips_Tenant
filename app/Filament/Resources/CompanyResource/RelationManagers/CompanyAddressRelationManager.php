<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CompanyAddressRelationManager extends RelationManager
{
    protected static string $relationship = 'company_address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Cep::make('zip_code')
                ->label('CEP')
                ->required()
                ->live(onBlur: true)
                ->viaCep(
                    mode: 'suffix',
                    errorMessage: 'CEP inválido.', 
                    setFields: [
                        'street' => 'logradouro',
                        'number' => 'numero',
                        'complement' => 'complemento',
                        'district' => 'bairro',
                        'city' => 'localidade',
                        'state' => 'uf'
                    ]
                ),
             
            TextInput::make('street')
                ->label('Logradouro')
                ->required()
                ->maxLength(255),
            TextInput::make('number')
                ->label('Número')
                ->required(),
            TextInput::make('complement')
                ->label('Complemento'),
            TextInput::make('district')
                ->label('Bairro')
                ->required(),
            TextInput::make('city')
                ->label('Cidade')
                ->required(),
            TextInput::make('state')
                ->label('Estado')
                ->required(),
            TextInput::make('reference')
                ->label('Ponto de Referência'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Endereço')
            ->columns([
                Tables\Columns\TextColumn::make('zip_code')
                    ->label('CEP'),
                Tables\Columns\TextColumn::make('street')
                    ->label('Logradouro'),
                Tables\Columns\TextColumn::make('number')
                    ->label('Número'),
                Tables\Columns\TextColumn::make('complement')
                    ->label('Complemento'),
                Tables\Columns\TextColumn::make('district')
                    ->label('Bairro'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade'),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Ponto de Referência')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
