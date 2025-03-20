<?php
namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::orderBy('created_at', 'desc')->get();
        return view('burgers.index', compact('burgers'));
    }

    public function create()
    {
        return view('burgers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $imagePath;
        }

        Burger::create($validated);
        return redirect()->route('burgers.index')->with('success', 'Burger créé avec succès');
    }

    public function show(Burger $burger)
    {
        return view('burgers.show', compact('burger'));
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $imagePath;
        }

        $burger->update($validated);
        return redirect()->route('burgers.index')->with('success', 'Burger modifié avec succès');
    }

    public function destroy(Burger $burger)
    {
        if ($burger->image) {
            Storage::disk('public')->delete($burger->image);
        }
        $burger->delete();
        return redirect()->route('burgers.index')->with('success', 'Burger supprimé avec succès');
    }

    public function catalogue(Request $request)
    {
        $query = Burger::where('disponible', true)
            ->where('stock', '>', 0);

// Appliquer le filtre par nom si présent
        if ($request->has('nom') && $request->nom != '') {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

// Appliquer le filtre par prix minimum si présent
        if ($request->has('prix_min') && $request->prix_min != '') {
            $query->where('prix', '>=', $request->prix_min);
        }

// Appliquer le filtre par prix maximum si présent
        if ($request->has('prix_max') && $request->prix_max != '') {
            $query->where('prix', '<=', $request->prix_max);
        }

// Récupérer les burgers filtrés
        $burgers = $query->orderBy('nom')->get();

        return view('burgers.catalogue', compact('burgers'));
    }
}
