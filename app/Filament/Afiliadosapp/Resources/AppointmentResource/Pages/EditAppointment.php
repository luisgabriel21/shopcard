<?php

namespace App\Filament\Afiliadosapp\Resources\AppointmentResource\Pages;

use App\Filament\Afiliadosapp\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
