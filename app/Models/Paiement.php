<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'montant',
        'mode_paiement'
    ];

    protected $casts = [
        'montant' => 'integer'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
