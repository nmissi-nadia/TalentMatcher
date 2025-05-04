<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signalement;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\User;

class ModerationController extends Controller
{
    public function index()
    {
        $signalements = Signalement::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Signalement::count(),
            'en_attente' => Signalement::where('statut', 'pending')->count(),
            'resolus' => Signalement::where('statut', 'resolved')->count(),
            'rejetes' => Signalement::where('statut', 'rejected')->count()
        ];

        return view('admin.moderation', compact('signalements', 'stats'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:annonce,candidature,profil',
            'id' => 'required|integer',
            'motif' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeMapping = [
            'annonce' => Annonce::class,
            'candidature' => Candidature::class,
            'profil' => User::class
        ];

        $signalement = new Signalement();
        $signalement->user_id = Auth::id();
        $signalement->cible_type = $typeMapping[$validated['type']];
        $signalement->cible_id = $validated['id'];
        $signalement->motif = $validated['motif'];
        $signalement->description = $validated['description'];
        $signalement->statut = 'pending';
        $signalement->save();

        return redirect()->back()->with('message', 'Signalement envoyé avec succès');
    }
    public function traiter(Request $request, $id)
    {
        $signalement = Signalement::findOrFail($id);
        
        $signalement->update([
            'statut' => $request->statut,
            'traitement_description' => $request->description,
            'traitement_date' => now()
        ]);

        return redirect()->back()->with('message', 'Le signalement a été traité avec succès.');
    }
}
