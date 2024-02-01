<?php

namespace App\Filament\Aliadosapp\Resources\PqrsResource\Pages;

use App\Filament\Aliadosapp\Resources\PqrsResource;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditPqrs extends EditRecord
{
    protected static string $resource = PqrsResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()->disabled(),
                Forms\Components\Select::make('target_user_id')
                    ->relationship('targetUser', 'name')
                    ->required()->disabled(),
                Forms\Components\Radio::make('type')
                    ->options([
                        'Petición' => 'Petición',
                        'Queja' => 'Queja',
                        'Reclamo' => 'Reclamo',
                        'Sugerencia' => 'Sugerencia'
                    ])->default('Petición')->inline()->disabled(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()->disabled(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
