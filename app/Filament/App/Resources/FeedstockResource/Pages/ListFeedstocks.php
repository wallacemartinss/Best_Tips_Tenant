<?php

namespace App\Filament\App\Resources\FeedstockResource\Pages;

use App\Filament\App\Resources\FeedstockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeedstocks extends ListRecords
{
    protected static string $resource = FeedstockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
