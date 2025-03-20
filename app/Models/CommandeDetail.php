<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeDetail extends Model
{
    use HasFactory;

    protected $table = 'commande_details';

    protected $fillable = [
        'commande_id',
        'burger_id',
        'quantite',
        'prix_unitaire'
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'integer'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }

    public function getTotal()
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
