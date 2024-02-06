<?php

namespace App\Filament\Aliadosapp\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ServicesStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 5;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {

        $query = DB::table('appointments')
        ->selectRaw('count(appointments.id) as number_of_appointments, services.name as name')
        ->join('services', 'services.id', '=', 'appointments.service_id')
        ->where('appointments.user_id', '=', auth()->user()->id) 
        ->where('appointments.appointment_datetime', '<', now()) 
        ->groupBy('name')
        ->get();
    
    $data=[];
    $labels=[];
    foreach ($query as $key => $value) {
        $data[]=$value->number_of_appointments;
        $labels[]=$value->name;
    }

    return [
        //
        'datasets' => [
            [
                'label' => 'Citas por tipo de servicio',
                'data' => $data,
                'backgroundColor' => [
                    '#e67e22',
                    '#eb984e',
                    '#f39c12',
                    '#f5b041',
                    '#f8c471',
                    '#facf80',
                    '#fde3a7',
                    '#fee6b4',
                    '#ffebc7',
                    '#fff2db',
                  ],
                'borderColor' => [
                    '#d35400',
                    '#cf7d5e',
                    '#e67e22',
                    '#e08b39',
                    '#eda26c',
                    '#f3c08f',
                    '#f8daaa',
                    '#f9dfb7',
                    '#fce5c6',
                    '#fdf1dc',
                  ],
            ],
        ],
        'labels' => $labels,
    ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    public function getDescription(): ?string
    {
        return 'Número de citas por tipo de servicio según todo el historial de citas en el sistema';
    }
    public function getHeading():?string
    {
        return 'Citas por tipo de servicio';
    }
}
