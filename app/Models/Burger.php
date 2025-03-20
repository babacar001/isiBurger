<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image',
        'stock',
        'disponible'
    ];

    protected $casts = [
        'prix' => 'integer',
        'stock' => 'integer',
        'disponible' => 'boolean'
    ];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_details')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }
}
