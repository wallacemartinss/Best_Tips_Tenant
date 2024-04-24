<?php

namespace App\Filament\App\Resources;

use Filament\Tables;
use App\Models\Company;
use App\Models\Mensure;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Feedstock;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\EditAction;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\App\Resources\FeedstockResource\Pages;
use App\Filament\App\Resources\FeedstockResource\RelationManagers;
use App\Filament\App\Resources\FeedstockResource\Pages\EditFeedstock;
use App\Filament\App\Resources\FeedstockResource\Pages\ListFeedstocks;
use App\Filament\App\Resources\FeedstockResource\Pages\CreateFeedstock;
use Leandrocfe\FilamentPtbrFormFields\Money;


class FeedstockResource extends Resource
{
    protected static ?string $model = Feedstock::class;

    protected static ?string $navigationIcon = 'fas-box-open';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Matérias-primas';
    protected static ?string $modelLabel = 'Insumo';
    protected static ?string $modelLabelPlural = "Insumos";
    protected static ?int $navigationSort = 1;
    protected static bool $isScopedToTenant = true;


    public static function form(Form $form): Form
    {
        $tenant = Filament::getTenant();
        $tenant = $tenant->id;

        return $form
        
            ->schema([

                Fieldset::make('Dados do Produto')
                    ->schema([
                        TextInput::make('description')
                            ->label('Descrição')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('manufacturer')
                            ->label('Fabricante/Marca')
                            ->maxLength(255),
                    ]),

                Fieldset::make('Dados da compra')
                    ->schema([
                        Select::make('units_id')
                            ->Label('Unidade')
                            ->relationship(name: 'units', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('mensures_id', null);
                            })
                            ->required(),

                        Select::make('mensures_id')
                            ->Label('Medida Comprada')
                            ->options(fn (Get $get): Collection => Mensure::query()->where('unit_id', $get('units_id'))->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        TextInput::make('quantity')
                            ->label('Quantidade')
                            ->suffix(function (Get $get) {
                                $simbol = Mensure::query()->where('id', $get('mensures_id'));
                                return $simbol->value('name');
                            })
                            ->required()
                            ->numeric(),

                        Money::make('value')
                            ->label('Valor pago no produto')
                            ->required(),

                    ]),

                TextInput::make('calculate_value')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                TextColumn::make('units.name')
                    ->label('Unidade')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('manufacturer')
                    ->label('Fabricante/Marca')
                    ->sortable()
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantidade adquirida')
                    ->alignRight()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('mensures.simbol')
                    ->label('Medida Adquirida')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Valor Pago na unidade')
                    ->money('brl')
                    ->sortable(),
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
            'index' => Pages\ListFeedstocks::route('/'),
            'create' => Pages\CreateFeedstock::route('/create'),
            'edit' => Pages\EditFeedstock::route('/{record}/edit'),
        ];
    }
}
