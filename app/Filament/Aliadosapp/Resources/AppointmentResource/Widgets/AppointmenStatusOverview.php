<?php

namespace App\Filament\Aliadosapp\Resources\AppointmentResource\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmenStatusOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $Solicitada=Appointment::query()->where('user_id', auth()->id())->where('status', 'Solicitada')->count();
        $Aprobada=Appointment::query()->where('user_id', auth()->id())->where('status', 'Aprobada')->count();
        $Cancelada=Appointment::query()->where('user_id', auth()->id())->where('status', 'Cancelada')->count();
           
        return [
            //
            Stat::make('Solicitada', $Solicitada)->description('Número de citas en estado solicitada')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->color('warning'),
            Stat::make('Aprobada', $Aprobada)->description('Número de citas aprobadas')
            ->descriptionIcon('heroicon-m-check-circle')
            ->color('success'),
            Stat::make('Cancelada', $Cancelada)->description('Número de citas canceladas')
            ->descriptionIcon('heroicon-m-x-circle')
            ->color('danger'),

        ];
    }
}
