<?php

namespace App\Filament\Fabricator\PageBlocks;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
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
                Hidden::make('aliado')
                    ->default(auth()->user()),
                FileUpload::make('image')
                    ->image(), 
                Select::make('service_id'),
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