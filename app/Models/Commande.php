<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'statut'
    ];



    protected $casts = [
        'total' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function burgers()
    {
        return $this->belongsToMany(Burger::class, 'commande_details')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }


    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
