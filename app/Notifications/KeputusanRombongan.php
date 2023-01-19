<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class KeputusanRombongan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $butiran;

    public function __construct($butiran)
    {
       $this->butiran=$butiran;        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $negaraRom = $this->butiran['negaraRom'];
        $tarikhMulaRom = $this->butiran['tarikhMulaRom'];
        $tarikhAkhirRom = $this->butiran['tarikhAkhirRom'];
        $keputusan = $this->butiran['keputusan'];

        return (new MailMessage)
        ->subject('ELN: PEMAKLUMAN KELULUSAN PERMOHONAN ROMBONGAN KELUAR NEGARA')
        ->markdown('mail.permohonan.keputusan-rombongan', [
            'negaraRom' => $negaraRom,
            'tarikhMulaRom' => $tarikhMulaRom,
            'tarikhAkhirRom' => $tarikhAkhirRom,
            'keputusan' => $keputusan,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
