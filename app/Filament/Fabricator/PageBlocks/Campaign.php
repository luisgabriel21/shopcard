<?php

namespace App\Filament\Fabricator\PageBlocks;

use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;


use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;

class Campaign extends PageBlock
{
    public static function getBlockSchema(): Block
    {

        return Block::make('campaign')
            ->schema([
                Select::make('aliado')
                ->label('Aliado')
                ->options(User::all()->where('id', auth()->id())->pluck('name', 'name'))->required(),
                FileUpload::make('image')
                    ->image(), 
                Select::make('servicio')
                ->label('Servicio')
                ->options(Service::all()->where('user_id', auth()->id())->pluck('name', 'name')),
                DatePicker::make('fechaini')
                ->required(),
                DatePicker::make('fechafin')
                ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}