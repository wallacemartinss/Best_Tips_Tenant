<?php

namespace App\Forms\Components;

use Closure;
use Carbon\Carbon;
use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component as Livewire;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Validation\ValidationException;

class SearchCnpj extends TextInput
{
public bool $validation = true;
 public function Cnpj(
   
    array $setFields = [],
    array $campos = [],
    array $secondary_activities = [],
    array $primary_activities = [],
    string $errorMessage = '',

 ): static {
    $CnpjRequest = function (
        $state,
        $livewire,
        $set,
        $component,  
        array $setFields,
        string $errorMessage = '',

    ) {
        //Formatar CNPJ para retirada de caracteres especiais
        $state = trim($state);
        $state = str_replace(array('.', '-', '/'), "", $state);
        
        //buscar api CNPJ.WS
        $request = Http::get("https://publica.cnpj.ws/cnpj/$state")->json();

        //Validar status da Consulta
        if ( isset($request['status'])) {
            throw ValidationException::withMessages([
                $component->getKey() => $errorMessage = $request['detalhes'],
            ]);

        }else{


        if ($request['simples'] === null) {
            $request['simples']['simples'] = 'Não';
            $request['simples']['mei'] = 'Não';
        }

        //Dados Básicos da Empresa
        $simple_situation = $request['simples']['simples'];
        $simei_situation = $request['simples']['mei'];
        $social_reason = Str::title($request['razao_social']);
        $type_company = Str::title($request['estabelecimento']['tipo']);
        $fantasy_name = Str::title($request['estabelecimento']['nome_fantasia']);
        $open_date = Carbon::parse($request['estabelecimento']['data_inicio_atividade'])->format('d/m/Y');
        $status = Str::title($request['estabelecimento']['situacao_cadastral']);
        $company_size = Str::title($request['porte']['descricao']);
        $legal_nature = Str::title($request['natureza_juridica']['descricao']);
        $share_capital = Str::title($request['capital_social']);
        $email = $request['estabelecimento']['email'];
        $phone = $request['estabelecimento']['ddd1'] . ' ' . $request['estabelecimento']['telefone1'];
        $state_registration_number = $request['estabelecimento']['inscricoes_estaduais'][0]['inscricao_estadual'];
        $state_registration_name = $request['estabelecimento']['inscricoes_estaduais'][0]['ativo'];
        $state_registration_status= $request['estabelecimento']['inscricoes_estaduais'][0]['estado']['nome'];
        $state_registration_date = Carbon::parse($request['estabelecimento']['inscricoes_estaduais'][0]['atualizado_em'])->format('d/m/Y');        
        $state_registration_acronym = $request['estabelecimento']['inscricoes_estaduais'][0]['estado']['sigla'];

        //Dados Endereço da Empresa
        $zip_code = $request['estabelecimento']['cep'];
        $street = Str::title($request['estabelecimento']['tipo_logradouro'] . ' ' . $request['estabelecimento']['logradouro']);
        $number =  $request['estabelecimento']['numero'];
        $district = Str::title($request['estabelecimento']['bairro']);
        $city = Str::title($request['estabelecimento']['cidade']['nome']);
        $state = $request['estabelecimento']['estado']['nome'];
        $complement = $request['estabelecimento']['complemento'];

        //Dados CNAE Atividade primarias da Empresa
        $principal_cnae_description[] = Str::title($request['estabelecimento']['atividade_principal']['descricao']);
        $principal_cnae_code[] = $request['estabelecimento']['atividade_principal']['subclasse'];

        $primary_activitie = array_combine($principal_cnae_code, $principal_cnae_description);

        //Dados CNAE Atividade Secundária da Empresa
        foreach ($request['estabelecimento']['atividades_secundarias'] as $key => $value) {
            $secondary_activitie_cnae[] =($value['subclasse']);
            $secondary_activitie_description[] = Str::title($value['descricao']);
        }

            //Se empresa não Possuio CNAE Atividade Secundária sta variavel como Null
            if(empty($secondary_activitie_cnae)){
                $secondary_activitie = null;
            }else{
                $secondary_activitie = array_combine($secondary_activitie_cnae, $secondary_activitie_description);
            }

        //Construção novo Array Formatado
        $request = [
            'social_reason' => $social_reason,
            'fantasy_name' => $fantasy_name,
            'open_date' => $open_date,
            'status' => $status,
            'company_size' => $company_size,
            'legal_nature' => $legal_nature,
            'share_capital' => $share_capital,
            'email' => $email,
            'phone' => $phone,
            'simple_situation' => $simple_situation,
            'simei_situation' => $simei_situation,
            'zip_code' => $zip_code,
            'street' => $street,
            'number' => $number,
            'district' => $district,
            'city' => $city,
            'state' => $state,
            'complement' => $complement,
            'secondary_activitie' => $secondary_activitie,
            'primary_activitie' => $primary_activitie,
            'type_company' => $type_company,
            'state_registration_number' => $state_registration_number,
            'state_registration_name' => $state_registration_name,
            'state_registration_status' => $state_registration_status,
            'state_registration_date' => $state_registration_date,
            'state_registration_acronym' => $state_registration_acronym,
        ];

        foreach ($setFields as $key => $value) {
            $set($key, $request[$value] ?? null);
        }   
        }
    };
        
    $this
        ->mask('99.999.999/9999-99')
        ->minLength(18)
        ->suffixAction(            
    Action::make('search-action')
                ->label('buscar por CNPJ')
                ->icon('heroicon-o-magnifying-glass')
                ->action(function($state, Livewire $livewire, Set $set, Component $component) use ($errorMessage, $CnpjRequest, $setFields) {
                    $CnpjRequest($state, $livewire, $set, $component, $setFields, $errorMessage);
                }),                               
             );

     return $this;
 }
 

}
