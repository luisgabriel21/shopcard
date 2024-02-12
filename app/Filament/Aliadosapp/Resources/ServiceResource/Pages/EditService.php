<?php

namespace App\Filament\Aliadosapp\Resources\ServiceResource\Pages;

use App\Filament\Aliadosapp\Resources\ServiceResource;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            
        ];
    }
}
