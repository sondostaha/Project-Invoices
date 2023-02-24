<?php

namespace App\Notifications;

use App\Models\invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Add_new_invoice extends Notification
{
    use Queueable;

    private $offerData;
   
    public function __construct($offerData)
    {
        $this->offerData = $offerData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'offer_id' => $this->offerData['offer_id'],
            'title'=>$this->offerData['body'],
            'user' => $this->offerData['user'],
            'url' => $this->offerData['offerUrl'],
           
            
        ];
    }
}
