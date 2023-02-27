<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TagihanLainNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $tagihan;
    public function __construct($tagihan)
    {
        $this->tagihan = $tagihan;
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
            'tagihan_id' => $this->tagihan->id,
            'title' => 'Tagihan ' . $this->tagihan->biaya->nama . ' Bulan ' . $this->tagihan->siswa->nama,
            'messages' => 'Tagihan ' . $this->tagihan->biaya->nama . ' Bulan ' . $this->tagihan->tanggal_tagihan->translatedFormat('F Y'),
            'url' => route('wali.tagihan.show', $this->tagihan->id),
        ];
    }

    public function toWhacenter($notifiable)
    {
        // $url = URL::temporarySignedRoute(
        //     'login.url',
        //     now()->addDays(10),
        //     [
        //         'tagihan_id' => $this->tagihan->id,
        //         'user_id' => $notifiable->id,
        //         'url' => route('wali.tagihan.show', $this->tagihan->id)
        //     ]
        // );

        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line("Assalamualaikum dan salam sejahtera ayah bunda semoga dalam keadaan sehat selalu,")
            ->line('Berikut kami kirim informasi tagihan ' . $this->tagihan->biaya->nama . ' untuk bulan ' . $this->tagihan->tanggal_tagihan->translatedFormat('F') . ' atas nama '
                . $this->tagihan->siswa->nama);
        // ->line('Jika sudah melakukan pembayaran silahkan klik link berikut: '. $url)
        // ->line('Link ini berlaku selama 10 hari.')
        // ->line('JANGAN BERIKAN LINK INI KESIAPAPUN.');
    }
}
