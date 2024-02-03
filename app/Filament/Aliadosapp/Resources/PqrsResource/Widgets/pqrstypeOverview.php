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
            Stat::make('Peticiones', $peticiones),
            Stat::make('Quejas', $quejas),
            Stat::make('Reclamos', $reclamos),
            Stat::make('Solicitudes', $solicitudes),
        ];
    }
}
