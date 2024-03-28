<?php

namespace App\Filament\App\Pages;

use App\Models\Company;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\CompanyType;
use Filament\Actions\Action;
use App\Models\CompanyAddress;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Filament\Forms\Concerns\InteractsWithForms;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class MyCompany extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $companyformData = [];
    public ?array $companyaddressData = [];
    protected static ?string $model = Company::class;
    protected static string $view = 'filament.app.pages.my-company';
    protected static ?string $navigationIcon = 'fas-building';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $navigationLabel = 'Minha Empresa';
    protected static ?int $navigationSort = 1;
    protected static bool $isScopedToTenant = true;

    protected function getForms(): array
    {
        return [
            'Company',
            'Companyaddress',
        ];
    }

    public function mount(): void
    {
        $tenant = Filament::getTenant();
        $organization_id = $tenant->id;
        $validation = Company::where('organization_id', $organization_id)->first();


        if ($validation === null) {
            $this->Company->fill();
            $this->Companyaddress->fill();
        } else {
            $this->companyformData = Company::where('organization_id', $organization_id)->first()->attributesToArray();
            $this->companyaddressData = CompanyAddress::where('organization_id', $organization_id)->first()->attributesToArray();
        }
    }
    public function Company(Form $form): Form
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
            ->statePath('companyformData');
    }

    public function Companyaddress(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Endereço da Empresa')
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
                    ])->columns(3),
            ])
            ->statePath('companyaddressData');
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
        $datacompany = $this->Company->getState();
        $companyaddressData = $this->Companyaddress->getState();
        $tenant = Filament::getTenant();

        $organization_id = $tenant->id;
        $validation = Company::where('organization_id', $organization_id)->first();

        if ($validation === null) {
            try {

                //Criação do Array de dados para inserir na tabela Company
                $company_array = array("organization_id" => $organization_id);
                $datacompany = array_merge($company_array, $datacompany);

                //Insere os dados na tabela Company
                Company::where('organization_id', $organization_id)->create($datacompany);

                //query para buscar o id da empresa
                $id_company = Company::where('organization_id', $organization_id)->first();
                $id_company = $id_company->id;

                //Criação do Array de dados para inserir na tabela CompanyAddress
                $adress_array = array("organization_id" => $organization_id, "company_id" => $id_company);
                $companyaddressData = array_merge($adress_array, $companyaddressData);
                CompanyAddress::where('organization_id', $organization_id)->create($companyaddressData);
            } catch (Halt $exception) {
                return;
            }
        } else {
            try {
                Company::where('organization_id', $organization_id)->update($datacompany);

                $id_company = Company::where('organization_id', $organization_id)->first();
                $id_company = $id_company->id;
                $adress_array = array("organization_id" => $organization_id, "company_id" => $id_company);
                $companyaddressData = array_merge($adress_array, $companyaddressData);

                CompanyAddress::where('company_id', $id_company)->update($companyaddressData);
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
