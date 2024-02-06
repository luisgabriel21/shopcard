<?php

namespace App\Filament\Aliadosapp\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AppointmentsStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 7;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '600px';
    protected int | string | array $columnSpan = 'full';


    

    protected function getData(): array
    {
        $data = Trend::query(Appointment::where('user_id', auth()->id()))
        ->dateColumn('appointment_datetime')
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Citas creadas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => [
                        '#2ecc71',
                        '#4caf50',
                        '#6dbb3e',
                        '#8dc553',
                        '#a8d159',
                        '#c5e861',
                        '#d9eb74',
                        '#e7f287',
                        '#f5f99a',
                        '#fcfaad',
                        ],
                    'borderColor' => [
                        '#29b765',
                        '#43a047',
                        '#5e9e3a',
                        '#76ac4e',
                        '#8bb55f',
                        '#a4cb6f',
                        '#b7da7e',
                        '#c7e994',
                        '#d6f5a8',
                        '#e0fcb5',
                      ],
                    
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'Conteo de número de citas creadas por mes';
    }
    public function getHeading():?string
    {
        return 'Citas por mes';
    }
}
