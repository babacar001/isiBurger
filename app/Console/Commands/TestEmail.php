<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email?}';
    protected $description = 'Envoie un email de test pour vérifier la configuration';

    public function handle()
    {
        $email = $this->argument('email') ?: 'pababacar0@gmail.com';

        $this->info("Envoi d'un email de test à $email...");

        try {
            Mail::raw('Ceci est un email de test envoyé depuis votre application Laravel', function($message) use ($email) {
                $message->to($email)
                    ->subject('Email de test');
            });

            $this->info('Email envoyé avec succès!');
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
        }
    }
}
