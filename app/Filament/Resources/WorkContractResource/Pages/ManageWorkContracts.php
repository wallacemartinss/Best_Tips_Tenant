<?php

namespace App\Filament\Resources\WorkContractResource\Pages;

use App\Filament\Resources\WorkContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkContracts extends ManageRecords
{
    protected static string $resource = WorkContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
