<?php

namespace App\Filament\Admin\Resources\PqrsmessageResource\Pages;

use App\Filament\Admin\Resources\PqrsmessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPqrsmessages extends ListRecords
{
    protected static string $resource = PqrsmessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
