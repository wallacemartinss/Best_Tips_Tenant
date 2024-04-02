<?php

namespace App\Filament\App\Resources\FeedstockResource\Pages;

use App\Filament\App\Resources\FeedstockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFeedstock extends CreateRecord
{
    protected static string $resource = FeedstockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
