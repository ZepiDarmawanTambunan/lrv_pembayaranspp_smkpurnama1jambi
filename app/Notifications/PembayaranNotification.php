<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $pembayaran;
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WhacenterChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'tagihan_id' => $this->pembayaran->tagihan_id,
            'wali_id' => $this->pembayaran->wali_id,
            'pembayaran_id' => $this->pembayaran->id,
            'title' => 'Pembayaran Tagihan',
            'messages' => $this->pembayaran->wali->name.' melakukan pembayaran tagihan.',
            'url' => route('pembayaran.show', $this->pembayaran->id),
        ];
    }

    public function toWhacenter($notifiable)
    {
        // $url = URL::temporarySignedRoute(
        //     'login.url',
        //     now()->addDays(10),
        //     [
        //         'pembayaran_id' => $this->pembayaran->id,
        //         'user_id' => $notifiable->id,
        //         'url' => route('pembayaran.show', $this->pembayaran->id)
        //     ]
        // );

        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line("Halo Operator, " . $notifiable->name)
            ->line('Ada Pembayaran Tagihan SPP')
            ->line($this->pembayaran->wali->name.' Melakukan pembayaran tagihan.');
            // ->line('Untuk melihat info pembayaran, klik link berikut: '. $url)
            // ->line('JANGAN BERIKAN LINK INI KESIAPAPUN.');
    }
}
