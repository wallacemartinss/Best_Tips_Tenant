<?php

namespace App\Filament\App\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Leandrocfe\FilamentPtbrFormFields\Document;
use App\Filament\App\Resources\UserResource\Pages;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    
    protected static ?string $navigationIcon = 'fas-users';
    protected static ?string $navigationGroup = 'Usúarios e Acessos';
    protected static ?string $navigationLabel = 'Usúarios';
    protected static ?string $modelLabel = 'Usúario';
    protected static ?string $modelLabelPlural = "Usúarios";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
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
                ->multiple()    
                ->relationship('roles', 'name'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
