<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use App\Models\Organization;
use Filament\Forms\Components\Grid;
use App\Forms\Components\SearchCnpj;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Tenancy\RegisterTenant;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;



class RegisterOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Registrar Empresa';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([


                Select::make('document_type')
                    ->label('Com qual Documento deseja registrar sua empresa?')
                    ->options([
                        'CPF' => 'CPF',
                        'CNPJ' => 'CNPJ',
                    ])
                    ->live()
                    ->afterStateUpdated(fn (Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicTypeFields')
                        ->getChildComponentContainer()
                        ->fill()),

                Grid::make(1)
                    ->schema(fn (Get $get): array => match ($get('document_type')) {

                        'CNPJ' => [
                            SearchCnpj::make('document_number')
                                ->label('Número do seu CNPJ')
                                ->required()
                                ->Cnpj(
                                    setFields: []
                                ),
                        ],

                        'CPF' => [
                            Document::make('document_number')
                                ->label('CPF')
                                ->cpf()
                                ->validation(true)
                                ->required(),
                        ],

                        default => [],
                    })->key('dynamicTypeFields'),

                TextInput::make('fantasy_name')
                    ->label('Nome da Empresa')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('email')
                    ->label('Email de contato')
                    ->email()
                    ->required(),

                PhoneNumber::make('phone')
                    ->label('Whatsapp de contato')
                    ->format('(99) 99999-9999')
                    ->required(),

                TextInput::make('slug')
                    ->label('Essa será a URL da sua empresa')
                    ->readonly(),
            ]);
    }

    protected function handleRegistration(array $data): Organization
    {
        $organization = Organization::create($data);
        $organization->members()->attach(auth()->user());
        return $organization;
    }
}
