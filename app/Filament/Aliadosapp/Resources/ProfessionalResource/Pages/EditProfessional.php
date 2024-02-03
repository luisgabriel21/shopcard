<?php

namespace App\Filament\Aliadosapp\Resources\ProfessionalResource\Pages;

use App\Filament\Aliadosapp\Resources\ProfessionalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfessional extends EditRecord
{
    protected static string $resource = ProfessionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
