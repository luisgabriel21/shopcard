<?php

namespace App\Filament\Aliadosapp\Resources\ServiceResource\Pages;

use App\Filament\Aliadosapp\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ServiceResource\Widgets\ServiceStatsOverview::class,
        ];
    }


}
