<?php

namespace App\Observers;

use App\Filament\Admin\Resources\PqrsResource;
use App\Models\Admin;
use App\Models\Affiliate;
use App\Models\Partner;
use App\Models\Pqrs;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AppointmentStatus;
use App\Notifications\SystemStatus;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class PqrsObserver
{
    /**
     * Handle the Pqrs "created" event.
     */
    public function created(Pqrs $pqrs): void
    {
        //
        $recipient = auth()->user();

        Notification::make()
        ->title(title:'Nueva PQRS:')
        ->warning()
        ->icon('heroicon-m-bell-alert')
        ->body( 
        '<p>- Fecha:<b>'.$pqrs->create_at.
        ' </b></p><p>- Creada por: <b>'.User::find($pqrs->user_id)->name.
        ' </b></p><p>- Dirigido a: <b>'.User::find($pqrs->target_user_id)->name.
        ' </b></p><p>- Tipo: <b>'.$pqrs->type.'</b></p>')
        ->sendToDatabase($recipient);  
        
        
        if (User::find($pqrs->target_user_id)->role_id==Role::ADMIN)
                $recipient = collect([Admin::find($pqrs->target_user_id)]);
            else if 
                (User::find($pqrs->target_user_id)->role_id==Role::PARTNER)
                    $recipient = collect([Partner::find($pqrs->target_user_id)]);
                    else if 
                    (User::find($pqrs->target_user_id)->role_id==Role::AFFILIATE)
                        $recipient = collect([Affiliate::find($pqrs->target_user_id)]);

        User::find($pqrs->target_user_id)->notify(new SystemStatus('Shopcard PQRS','¡Has recibido una nueva PQRS!'));


        Notification::make()
        ->title(title:'Nueva PQRS:')
        ->warning()
        ->icon('heroicon-m-bell-alert')
        ->body( 
        '<p>- Fecha:<b>'.$pqrs->create_at.
        ' </b></p><p>- Creada por: <b>'.User::find($pqrs->user_id)->name.
        ' </b></p><p>- Dirigido a: <b>'.User::find($pqrs->target_user_id)->name.
        ' </b></p><p>- Tipo: <b>'.$pqrs->type.'</b></p>')
        ->sendToDatabase($recipient);  
    }

    /**
     * Handle the Pqrs "updated" event.
     */
    public function updated(Pqrs $pqrs): void
    {
        //
        $recipient = auth()->user();

        Notification::make()
        ->title(title:'PQRS actualizada:')
        ->warning()
        ->icon('heroicon-m-bell-alert')
        ->body( 
        '<p>- Fecha:<b>'.$pqrs->create_at.
        ' </b></p><p>- Creada por: <b>'.User::find($pqrs->user_id)->name.
        ' </b></p><p>- Dirigido a: <b>'.User::find($pqrs->target_user_id)->name.
        ' </b></p><p>- Tipo: <b>'.$pqrs->type.'</b></p>')
        ->sendToDatabase($recipient);  
        
        $recipient = collect([Partner::find($pqrs->target_user_id)]);

        Notification::make()
        ->title(title:'PQRS actualizada:')
        ->warning()
        ->icon('heroicon-m-bell-alert')
        ->body( 
        '<p>- Fecha:<b>'.$pqrs->create_at.
        ' </b></p><p>- Creada por: <b>'.User::find($pqrs->user_id)->name.
        ' </b></p><p>- Dirigido a: <b>'.User::find($pqrs->target_user_id)->name.
        ' </b></p><p>- Tipo: <b>'.$pqrs->type.'</b></p>')
        ->sendToDatabase($recipient);      
    }

    /**
     * Handle the Pqrs "deleted" event.
     */
    public function deleted(Pqrs $pqrs): void
    {
        //
    }

    /**
     * Handle the Pqrs "restored" event.
     */
    public function restored(Pqrs $pqrs): void
    {
        //
    }

    /**
     * Handle the Pqrs "force deleted" event.
     */
    public function forceDeleted(Pqrs $pqrs): void
    {
        //
    }
}
