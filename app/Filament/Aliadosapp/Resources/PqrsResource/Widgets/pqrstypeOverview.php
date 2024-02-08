<?php

namespace App\Filament\Aliadosapp\Resources\PqrsResource\Widgets;

use App\Models\Pqrs;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class pqrstypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $peticiones=Pqrs::query()->where('user_id', auth()->id())->where('type', 'Peticion')->count()+Pqrs::query()->where('target_user_id', auth()->id())->where('type', 'Peticion')->count();
        $reclamos=Pqrs::query()->where('user_id', auth()->id())->where('type', 'Reclamo')->count()+Pqrs::query()->where('target_user_id', auth()->id())->where('type', 'Reclamo')->count();
        $quejas=Pqrs::query()->where('user_id', auth()->id())->where('type', 'Queja')->count()+Pqrs::query()->where('target_user_id', auth()->id())->where('type', 'Queja')->count();
        $solicitudes=Pqrs::query()->where('user_id', auth()->id())->where('type', 'Solicitud')->count()+Pqrs::query()->where('target_user_id', auth()->id())->where('type', 'Solicitud')->count();
           
        return [
            //
            Stat::make('Peticiones', $peticiones)->description('Número total de peticiones recibidas o realizadas')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->color('info'),
            Stat::make('Quejas', $quejas)->description('Número total de quejas recibidas o realizadas')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->color('danger'),
            Stat::make('Reclamos', $reclamos)->description('Número total de reclamos recibidos o realizados')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->color('warning'),
            Stat::make('Solicitudes', $solicitudes)->description('Número total de solicitudes recibidas o realizadas')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->color('info'),
        ];
    }
}
