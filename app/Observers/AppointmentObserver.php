<?php

namespace App\Observers;

use App\Models\Affiliate;
use App\Models\Appointment;
use App\Models\Professional;
use App\Models\User;
use App\Notifications\AppointmentStatus;
use App\Notifications\SystemStatus;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        $recipient = auth()->user();

        Notification::make()
        ->title(title:'Nueva cita creada:')
        ->success()
        ->icon('heroicon-m-calendar-days')
        ->body( 
        '<p>- Fecha:<b>'.$appointment->appointment_datetime.
        ' </b></p><p>- Profesional: <b>'.Professional::find($appointment->professional_id)->name.
        ' </b></p><p>- Usuario: <b>'.User::find($appointment->affiliate_id)->name.
        ' </b></p><p>- Estado: <b>'.$appointment->status.'</b></p>')
        ->sendToDatabase($recipient);  
        
        
        $recipient = collect([Affiliate::find($appointment->affiliate_id)]);

        User::find($appointment->affiliate_id)->notify(new SystemStatus('Shopcard Cita creada','Tienes una nueva cita: 
        - Fecha:'.$appointment->appointment_datetime.
        '- Profesional: '.Professional::find($appointment->professional_id)->name.
        '- Usuario: '.User::find($appointment->affiliate_id)->name.
        '- Estado: '.$appointment->status.'</b></p>'));

        Notification::make()
        ->title(title:'Nueva cita creada:')
        ->success()
        ->icon('heroicon-m-calendar-days')
        ->body( 
        '<p>- Fecha:<b>'.$appointment->appointment_datetime.
        ' </b></p><p>- Profesional: <b>'.Professional::find($appointment->professional_id)->name.
        ' </b></p><p>- Usuario: <b>'.User::find($appointment->affiliate_id)->name.
        ' </b></p><p>- Estado: <b>'.$appointment->status.'</b></p>')
        ->sendToDatabase($recipient);  

    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        //
        $recipient = auth()->user();

        Notification::make()
        ->title(title:'La cita fue actualizada:')
        ->info()
        ->icon('heroicon-m-calendar-days')
        ->body( 
        '<p>- Fecha:<b>'.$appointment->appointment_datetime.
        ' </b></p><p>- Profesional: <b>'.Professional::find($appointment->professional_id)->name.
        ' </b></p><p>- Usuario: <b>'.User::find($appointment->affiliate_id)->name.
        ' </b></p><p>- Estado: <b>'.$appointment->status.'</b></p>')
        ->sendToDatabase($recipient);  
        
        User::find($appointment->affiliate_id)->notify(new SystemStatus('Shopcard Cita Actualizada','La cita se ha actualizado: 
            - Fecha:'.$appointment->appointment_datetime.
            '- Profesional: '.Professional::find($appointment->professional_id)->name.
            '- Usuario: '.User::find($appointment->affiliate_id)->name.
            '- Estado: '.$appointment->status.'</b></p>'));

        $recipient = collect([Affiliate::find($appointment->affiliate_id)]);

        Notification::make()
        ->title(title:'La cita fue actualizada:')
        ->success()
        ->icon('heroicon-m-calendar-days')
        ->body( 
        '<p>- Fecha:<b>'.$appointment->appointment_datetime.
        ' </b></p><p>- Profesional: <b>'.Professional::find($appointment->professional_id)->name.
        ' </b></p><p>- Usuario: <b>'.User::find($appointment->affiliate_id)->name.
        ' </b></p><p>- Estado: <b>'.$appointment->status.'</b></p>')
        ->sendToDatabase($recipient); 
        
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
