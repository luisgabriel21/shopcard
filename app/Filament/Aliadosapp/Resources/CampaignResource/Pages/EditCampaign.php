<?php

namespace App\Filament\Aliadosapp\Resources\CampaignResource\Pages;

use App\Filament\Aliadosapp\Resources\CampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaign extends EditRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
