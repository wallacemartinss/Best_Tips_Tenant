<?php

namespace App\Filament\App\Resources;

use Exception;
use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Filament\Forms\Components\Actions\Action;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\SupplierResource\Pages;
use App\Filament\App\Resources\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'fas-boxes-packing';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Fornecedores';
    protected static ?string $modelLabel = 'Fornecedores';
    protected static ?string $modelLabelPlural = "Fornecedor";
    protected static ?int $navigationSort = -1;
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Informações básicas do fornecedor')
                ->schema([
                    Document::make('document_number')
                    ->label('CNPJ')
                    ->cnpj()                
                    ->validation(false)
                    ->required()
                    ->columnSpan(2)
                    ->suffixAction(
                        fn ($state, $set) => Forms\Components\Actions\Action::make('search-action')
                        ->icon('heroicon-s-magnifying-glass')
                        ->action(function() use ($state, $set) {
                            if (blank( $state )) {
                                Notification::make()
                                    ->title('Digite o CNPJ para bucar o fornecedor')
                                    ->danger()
                                    ->send();
                                return;
                            }
                                try {

                                    $state = trim($state);
                                    $state = str_replace(array('.','-','/'), "", $state);

                                    $cnpjData = Http::get(
                                        "https://api-publica.speedio.com.br/buscarcnpj?cnpj={$state}"
                                    )->throw()->json();

                                    if(in_array("error", $cnpjData)) {
                                        throw new Exception();
                                    }

                                }catch (Exception $e) {
                                        Notification::make()
                                            ->title('CNPJ inválido')
                                            ->danger()
                                            ->send();
                                    }

                                   //dd($cnpjData);

                                    $set('social_reason', $cnpjData['RAZAO SOCIAL']);
                                    $set('fantasy_name', $cnpjData['NOME FANTASIA']);
                                    $set('open_date', $cnpjData['DATA ABERTURA']);
                                    $set('cnae_description', $cnpjData['CNAE PRINCIPAL DESCRICAO']);
                                    $set('cnae_code', $cnpjData['CNAE PRINCIPAL CODIGO']);
                                    $set('status', $cnpjData['STATUS']);
                                    $set('email', $cnpjData['EMAIL']);
                                    $set('phone', $cnpjData['DDD'].''.$cnpjData['TELEFONE']);
                                    $set('zip_code', $cnpjData['CEP']);
                                    $set('street', $cnpjData['TIPO LOGRADOURO'].' '.$cnpjData['LOGRADOURO']);
                                    $set('number', $cnpjData['NUMERO']);
                                    $set('district', $cnpjData['BAIRRO']);
                                    $set('city', $cnpjData['MUNICIPIO']);
                                    $set('state', $cnpjData['UF']);
                                    $set('complement', $cnpjData['COMPLEMENTO']);
                                
                            })
                    ),

                TextInput::make('cnae_code')
                    ->columnSpan(1)
                    ->label('Código CNAE')
                    ->maxLength(255),

                TextInput::make('cnae_description')               
                    ->label('Descrição do CNAE')
                    ->columnSpan(3)
                    ->maxLength(255),


                TextInput::make('social_reason')
                    ->label('Razão Social')
                    ->columnSpan(3)
                    ->required()
                    ->maxLength(255),

                TextInput::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),
                
                TextInput::make('status')
                    ->label('Status CNPJ')
                    ->columnSpan(1)
                    ->maxLength(255),



                ])->columns(6),



                Fieldset::make('Informações de Contato')
                ->schema([
                        
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255),

                PhoneNumber::make('phone')
                    ->label('Telefone')
                    ->format('(99)99999-9999')
                    ->maxLength(255),

                ])->columns(2),



            
                Fieldset::make('Informações de Endereço')
                ->schema([
                
                Cep::make('zip_code')
                    ->label('CEP')
                    ->columnSpan(1)
            ->viaCep(
                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.
                 
                        /**
                         * Other form fields that can be filled by ViaCep.
                         * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                         * More information: https://viacep.com.br/
                         */
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
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),

                TextInput::make('number')
                    ->label('Numero')
                    ->columnSpan(1)
                    ->required()
                    ->maxLength(255),

                TextInput::make('complement')
                    ->label('Complemento')
                    ->columnSpan(2)
                    ->maxLength(255),

                TextInput::make('reference')
                    ->label('Referência')
                    ->columnSpan(4)
                    ->maxLength(255),

                Fieldset::make()
                ->schema([     
                    TextInput::make('district')
                        ->label('Bairro')
                        ->columnSpan(1)
                        ->required()
                        ->maxLength(255),

                    TextInput::make('city')
                        ->label('Cidade')
                        ->columnSpan(1)
                        ->required()
                        ->maxLength(255),

                    TextInput::make('state')
                        ->label('Estado')
                ])->columns(3),

                ])->columns(6),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fantasy_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('social_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnae_description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnae_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('complement')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
