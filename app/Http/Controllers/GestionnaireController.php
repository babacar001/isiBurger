<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandesEnCours = Commande::whereIn('statut', ['en_attente', 'en_preparation'])
            ->count();
        $commandesAujourdhui = Commande::whereDate('created_at', today())
            ->count();
        $burgersEnRupture = Burger::where('stock', 0)
            ->count();

        return view('dashboard.gestionnaire', compact(
            'commandesEnCours',
            'commandesAujourdhui',
            'burgersEnRupture'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
