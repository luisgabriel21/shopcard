<?php

namespace App\Filament\Aliadosapp\Widgets;

use App\Filament\Fabricator\PageBlocks\Campaign;
use App\Models\Appointment;
use App\Models\Campaign as ModelsCampaign;
use App\Models\Pqrs;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        //Datos Citas
        $data1=Trend::query(Appointment::where('user_id', auth()->id()))
        ->dateColumn('appointment_datetime')
        ->between(        
            start: now()->startOfWeek(),
            end: now()->endOfWeek(),
            )
        ->perDay()
        ->count();

        $conteo1=0;
        $chart1=[];
        foreach ($data1 as $key => $value) {
            $conteo1+=$value->aggregate;
            $chart1[]=$value->aggregate;
        }
        
        //Datos PQRS
        $data2=Trend::query(Pqrs::where('user_id', auth()->id()))
        ->between(        
            start: now()->startOfWeek(),
            end: now()->endOfWeek(),
            )
        ->perDay()
        ->count();

        $conteo2=0;
        $chart2=[];
        foreach ($data2 as $key => $value) {
            $conteo2+=$value->aggregate;
            $chart2[]=$value->aggregate;
        }

        $data0=Trend::query(Appointment::where('user_id', auth()->id()))
        ->dateColumn('appointment_datetime')
        ->between(        
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
            )
        ->perDay()
        ->count();
        $chart0=[];
        foreach ($data0 as $key => $value) {

            $chart0[]=$value->aggregate;
        }

        $data4=DB::table('campaigns')->where('user_id', auth()->id())->where('user_id', auth()->id())->count();

        return [
            Stat::make('Número de citas programadas para hoy', Appointment::query()->where('user_id', auth()->id())->whereDate('appointment_datetime', today())->count())
            ->description('Hoy')
            ->descriptionIcon('heroicon-m-bell-alert')
            ->chart($chart0)
            ->color('success'),
            Stat::make('Número de citas esta semana', $conteo1)
            ->description('Citas programadas para esta semana:')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chart1)
            ->color('info'),
            Stat::make('PQRS', $conteo2)
            ->description('Número de PQRS registradas esta semana:')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chart2)
            ->color('warning'),
            Stat::make('Marketing', $data4)
            ->description('Número de campañas creadas')
            ->descriptionIcon('heroicon-m-building-storefront')
            
            ->color('success'),             
        ];
    }
}
