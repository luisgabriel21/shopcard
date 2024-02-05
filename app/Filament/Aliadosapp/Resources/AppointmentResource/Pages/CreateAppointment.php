<?php

namespace App\Filament\Aliadosapp\Resources\AppointmentResource\Pages;

use App\Filament\Aliadosapp\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\RelationManagers\RelationManager;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;  
}
