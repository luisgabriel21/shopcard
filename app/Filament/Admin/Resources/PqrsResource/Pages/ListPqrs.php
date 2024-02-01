<?php

namespace App\Filament\Admin\Resources\PqrsResource\Pages;

use App\Filament\Admin\Resources\PqrsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPqrs extends ListRecords
{
    protected static string $resource = PqrsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
