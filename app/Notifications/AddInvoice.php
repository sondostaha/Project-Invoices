<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;

    private $invoices_id ;
    public function __construct($invoices_id)
    {
        $this->invoices_id = $invoices_id ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url ='http://127.0.0.1:8000/invoicesDetails/'.$this->invoices_id;

        return (new MailMessage)
                    ->subject('اضافه فاتوره جديده')
                    ->line('اضافه فاتوره جديده')
                    ->action('عرض الفاتوره', $url)
                    ->line('شكرا لاستخدامك موقع الفاتوير لاداره الفواتير');
    }

  
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
