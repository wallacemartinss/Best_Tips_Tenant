<?php 

namespace App\Filament\Pages\Tenancy;
 
use App\Models\Organization;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Filament\Pages\Tenancy\RegisterTenant;
 
class RegisterOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Organization';
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da Empresa')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
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