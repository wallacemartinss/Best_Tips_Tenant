<?php

namespace App\Filament\Resources\WorkContractResource\Pages;

use App\Filament\Resources\WorkContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkContract extends EditRecord
{
    protected static string $resource = WorkContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
