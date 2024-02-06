<?php

namespace App\Filament\Aliadosapp\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class ProfessionalStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {

        

        $query = DB::table('appointments')
            ->selectRaw('count(appointments.id) as number_of_appointments, professionals.name as name')
            ->join('professionals', 'professionals.id', '=', 'appointments.professional_id')
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
                    'label' => 'Citas por profesional',
                    'data' => $data,
                    'backgroundColor' => [
                        '#1f77b4',
                        '#3498db',
                        '#6fa1e5',
                        '#9ecae1',
                        '#c6dbef',
                        '#b3cde3',
                        '#8c96c6',
                        '#6674a0',
                        '#47567a',
                        '#2a2f4e',
                      ],
                    'borderColor' => [
                        '#1c6ca1',
                        '#2879b8',
                        '#4d8cd6',
                        '#76aee5',
                        '#a2c6f1',
                        '#9ab8d9',
                        '#7e8dbd',
                        '#586597',
                        '#3b446b',
                        '#1e2341',
                      ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    public function getDescription(): ?string
    {
        return 'Número de citas asignadas a cada profesional según todo el historial de citas en el sistema';
    }
    public function getHeading():?string
    {
        return 'Citas por profesional';
    }
    protected function getType(): string
    {
        return 'doughnut';
    }
}
