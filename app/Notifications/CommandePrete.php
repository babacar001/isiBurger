<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommandePrete extends Notification implements ShouldQueue
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre commande est prête')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre commande #' . $this->commande->id . ' est maintenant prête.')
            ->line('Vous pouvez la récupérer à notre restaurant.')
            ->line('Le montant total est de ' . number_format($this->commande->total / 100, 2) . ' €.')
            ->action('Voir ma commande', route('commandes.show', $this->commande))
            ->line('Merci d\'avoir commandé chez nous !');
    }

    public function toArray($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'message' => 'Votre commande #' . $this->commande->id . ' est prête',
            'total' => $this->commande->total
        ];
    }
}
