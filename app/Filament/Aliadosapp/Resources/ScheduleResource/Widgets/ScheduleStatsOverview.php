<?php

namespace App\Filament\Aliadosapp\Resources\ScheduleResource\Widgets;

use App\Models\Professional;
use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ScheduleStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $today=Schedule::query()->where('user_id', auth()->id())->where('schedule_date', Carbon::today()->toDateString())->distinct('professional_id')->count();
        $tomorrow=Schedule::query()->where('user_id', auth()->id())->where('schedule_date', Carbon::tomorrow()->toDateString())->distinct('professional_id')->count();
        $notoday=Professional::query()->where('user_id', auth()->id())->count()-$today;
        $notomorrow=Professional::query()->where('user_id', auth()->id())->count()-$tomorrow;

        return [
            //
            Stat::make('Hoy', $today)->description('Número de profesionales con agenda para hoy')
            ->descriptionIcon('heroicon-m-check-circle')
            ->color('success'),
            Stat::make('Mañana', $tomorrow)->description('Número de profesionales con agenda para mañana')
            ->descriptionIcon('heroicon-m-check-circle')
            ->color('success'),
            Stat::make('Sin Agenda hoy', $notoday)->description('Número de profesionales sin agenda para hoy')
            ->descriptionIcon('heroicon-m-x-circle')
            ->color('danger'),
            Stat::make('Sin Agenda mañana', $notomorrow)->description('Número de profesionales sin agenda para mañana')
            ->descriptionIcon('heroicon-m-x-circle')
            ->color('danger'),
        ];
    }
}
