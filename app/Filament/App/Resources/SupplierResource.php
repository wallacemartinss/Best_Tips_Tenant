<?php

namespace App\Filament\App\Resources;

use Exception;
use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
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
                                    ->action(function () use ($state, $set) {
                                        if (blank($state)) {
                                            Notification::make()
                                                ->title('Digite o CNPJ para bucar o fornecedor')
                                                ->danger()
                                                ->send();
                                            return;
                                        }
                                        try {
                                            $state = trim($state);
                                            $state = str_replace(array('.', '-', '/'), "", $state);

                                            $CNPJ_TOKEN = env('CNPJ_TOKEN');
                                            $cnpjData = Http::get(
                                                "http://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj={$state}&token={$CNPJ_TOKEN}",
                                            )->throw()->json();

                                            $valida_cnpj = $cnpjData['return'];
                                  
                                            if ($valida_cnpj === "NOK" ){
                                                throw new Exception();
                                            } else{
                                                $cnpjData = $cnpjData['result'];
                                                $cnae = $cnpjData['atividade_principal'];
                                                              
                                                if (empty($cnpjData['fantasia'])) {
                                                    $nome_fantasia = Str::title($cnpjData['nome']);
                                                } else {
                                                    $nome_fantasia = Str::title($cnpjData['fantasia']);
                                                }
                                                
                                                $set('social_reason', Str::title($cnpjData['nome']));
                                                $set('fantasy_name',  $nome_fantasia);
                                                $set('open_date', $cnpjData['abertura']);
                                                $set('status',  Str::title($cnpjData['situacao']));
                                                $set('email', $cnpjData['email']);
                                                $set('phone', $cnpjData['telefone']);
                                                $set('zip_code', $cnpjData['cep']);
                                                $set('street',  Str::title($cnpjData['logradouro']) );
                                                $set('number', $cnpjData['numero']);
                                                $set('district',  Str::title($cnpjData['bairro']));
                                                $set('city',  Str::title($cnpjData['municipio']));
                                                $set('state', $cnpjData['uf']);
                                                $set('complement', $cnpjData['complemento']);
                                                $set('cnae_description',  Str::title($cnae['text']));
                                                $set('cnae_code', $cnae['code']);

                                            }

                                        } catch (Exception $e) {
                                            Notification::make()
                                                ->title('CNPJ inválido')
                                                ->danger()
                                                ->send();
                                        }
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
                            ->columnSpan(1),

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
                    ->label('CNPJ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('social_reason')
                    ->label('Razão Social')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('zip_code')
                    ->label('CEP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->label('Logradouro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Numero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->label('Bairro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cnae_description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cnae_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status CNPJ')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('complement')
                    ->label('Complemento')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referência')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
