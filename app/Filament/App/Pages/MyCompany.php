<?php

namespace App\Filament\App\Pages;

use App\Models\Company;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\CompanyType;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Fieldset;

class MyCompany extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    protected static ?string $model = Company::class;
    protected static string $view = 'filament.app.pages.my-company';

    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationIcon = 'fas-building';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $navigationLabel = 'Minha Empresa';
    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $companyId = $tenant->id;
        $validation = Company::where('organization_id', $companyId)->first();

        if ($validation === null) {
            $this->form->fill();
        } else {
            $this->data = Company::where('organization_id', $companyId)->first()->attributesToArray();
        }
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Enquadramento e Documento')
                ->schema([
                    Select::make('company_type_id')
                        ->label('Tipo de empresa')
                        ->options(CompanyType::all()->pluck('name', 'id'))
                        ->searchable()
                        ->preload(),

                    Document::make('document_number')
                        ->label('CNPJ da Empresa ou CPF caso não tenha CNPJ')
                        ->dynamic()
                        ->required()
                        ->validation(false)
                        ->maxLength(255),

                ])->columns(2),

                Fieldset::make('Dados da Empresa')
                ->schema([
                    TextInput::make('name')
                        ->label('Razão Social')
                        ->maxLength(255),
                    TextInput::make('fantasy_name')
                        ->label('Nome Fantasia')
                        ->maxLength(255),
                    PhoneNumber::make('phone_number')
                        ->label('Telefone')
                        ->format('(99)99999-9999')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->maxLength(255),
                ])->columns(3),
            ])
            ->statePath('data');
    }
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
    public function save(): void
    {
        $data = $this->form->getState();
        $tenant = Filament::getTenant();
        $companyId = $tenant->id;

        $validation = Company::where('organization_id', $companyId)->first();
        $array1 = array("organization_id" => $companyId);

        if ($validation === null) {
            try {
                $data = array_merge($array1, $data);
                Company::where('organization_id', $companyId)->create($data);
            } catch (Halt $exception) {
                return;
            }
        } else {
            try {
                Company::where('organization_id', $companyId)->update($data);
            } catch (Halt $exception) {
                return;
            }
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
