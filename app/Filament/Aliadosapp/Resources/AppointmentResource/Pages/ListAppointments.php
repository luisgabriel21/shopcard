<?php

namespace App\Filament\Aliadosapp\Resources\AppointmentResource\Pages;

use App\Filament\Afiliadosapp\Resources\AppointmentResource as ResourcesAppointmentResource;
use App\Filament\Aliadosapp\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            AppointmentResource\Widgets\AppointmenStatusOverview::class,           
        ];
    }
}
