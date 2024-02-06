<?php

namespace App\Filament\Aliadosapp\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAppointments extends BaseWidget
{
    protected static ?int $sort = 8;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Últimas Citas creadas';
    

    public function table(Table $table): Table
    {
        return $table
            ->query(Appointment::where('user_id', auth()->id())->limit(20))
            ->defaultSort('created_at', 'desc') 
            ->columns([
                Tables\Columns\ImageColumn::make('professional.image'),
                Tables\Columns\TextColumn::make('professional.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('afilliate.name')
                ->numeric(),
                Tables\Columns\TextColumn::make('service.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('appointment_datetime')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('status')
            ]);
    }
}
