<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Filament\Pages\Auth\Register as AuthRegister;

class Register extends AuthRegister
{

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getDocumentNumberFormComponent(),
                $this->getNameFormComponent(),
                $this->getLastNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label('Sobrenome')
            ->required();
    }

    protected function getDocumentNumberFormComponent(): Component
    {
        return  Document::make('document_number')
            ->validation(false)
            ->cpf()
            ->label('Seu CPF')
            ->required();
    }
}
