<?php

namespace App\Filament\Aliadosapp\Resources\ProfessionalResource\Widgets;

use App\Models\Appointment;
use App\Models\Professional;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ProfessionalStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $statsitems=[];
        //total servicios
        $numtotal=Professional::query()->where('user_id', auth()->id())->count();
        $statsitems[]=Stat::make('Hoy', $numtotal)->description('Número total de profesionales')
                        ->descriptionIcon('heroicon-m-user-group')
                        ->color('secondary');


        //Calcular total citas a la fecha por servicio top 3
        $report = DB::table('appointments')
                ->selectRaw('count(id) as number_of_appointments, professional_id')
                ->where('user_id', auth()->id())
                ->groupBy('professional_id')
                ->orderBy('number_of_appointments', 'desc')->limit(3)
                ->get();
         
        foreach($report as $appointmentsnum)
         {
            $topservice=$appointmentsnum->number_of_appointments;
            $statsitems[]= Stat::make(Professional::findorFail($appointmentsnum->professional_id)->name, $topservice)->description('Top profesionales con más citas hasta hoy')
            ->descriptionIcon('heroicon-m-trophy')
            ->color('success');
         } 
        
        return $statsitems;
    }
}
