<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureCommande extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $pdf;

    public function __construct(Commande $commande, $pdf)
    {
        $this->commande = $commande;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Votre commande #' . $this->commande->id . ' est prête')
            ->markdown('emails.commandes.facture')
            ->attachData($this->pdf->output(), 'facture-commande-' . $this->commande->id . '.pdf');
    }
}
