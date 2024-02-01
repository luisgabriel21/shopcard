<?php

namespace App\Filament\Admin\Resources\PqrsmessageResource\Pages;

use App\Filament\Admin\Resources\PqrsmessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPqrsmessage extends EditRecord
{
    protected static string $resource = PqrsmessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
