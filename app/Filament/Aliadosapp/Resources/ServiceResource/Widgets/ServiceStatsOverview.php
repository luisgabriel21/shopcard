<?php

namespace App\Filament\Aliadosapp\Resources\ServiceResource\Widgets;

use App\Models\Appointment;
use App\Models\Service;
use Doctrine\DBAL\Query\Limit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $statsitems=[];
        //total servicios
        $numtotal=Service::query()->where('user_id', auth()->id())->count();
        $statsitems[]=Stat::make('Hoy', $numtotal)->description('Número total de servicios que ofrecemos')
                        ->descriptionIcon('heroicon-m-folder')
                        ->color('secondary');


        //Calcular total citas a la fecha por servicio top 3
        $report = DB::table('appointments')
                ->selectRaw('count(id) as number_of_services, service_id')
                ->where('user_id', auth()->id())
                ->groupBy('service_id')
                ->orderBy('number_of_services', 'desc')->limit(3)
                ->get();
         
        foreach($report as $servicenum)
         {
            $topservice=$servicenum->number_of_services;
            $statsitems[]= Stat::make(Service::findorFail($servicenum->service_id)->name, $topservice)->description('Top servicios con más citas hasta hoy')
            ->descriptionIcon('heroicon-m-trophy')
            ->color('success');
         } 
        
        return $statsitems;

    }
}
