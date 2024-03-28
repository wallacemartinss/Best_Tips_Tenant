<?php

namespace App\Filament\Resources;


use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Column;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\UserResource\Pages;
use Leandrocfe\FilamentPtbrFormFields\Document;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'fas-users';
    protected static ?string $navigationGroup = 'Usúarios e Acessos';
    protected static ?string $navigationLabel = 'Usúarios';
    protected static ?string $modelLabel = 'Usúario';
    protected static ?string $modelLabelPlural = "Usúarios";
    protected static ?int $navigationSort = 1;
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('organization_id')
                ->label('Tenant')
                ->relationship('organization', 'name')
                ->required(),
                TextInput::make('name')
                    ->label('Primeiro Nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Sobrenome')
                    ->required()
                    ->maxLength(255),
                Document::make('document_number')
                    ->label('CPF')
                    ->validation(false)
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->hiddenOn('edit')
                    ->maxLength(255),
                Select::make('role')
                    ->label('Permissão')
                    ->multiple()
                    ->relationship('roles', 'name'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('organization.name')
                    ->label('Tenant')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Primeiro Nome')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Sobrenome')
                    ->searchable(),
                TextColumn::make('document_number')
                    ->label('CPF')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                ToggleColumn::make('active')
                    ->label('Ativo'),
                TextColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                textColumn::make('updated_at')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
