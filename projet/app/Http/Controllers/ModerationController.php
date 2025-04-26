<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signalement;

class ModerationController extends Controller
{
    public function index()
    {
        $signalements = Signalement::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Signalement::count(),
            'en_attente' => Signalement::where('statut', 'an_attente')->count(),
            'resolus' => Signalement::where('statut', 'resolus')->count(),
            'rejetes' => Signalement::where('statut', 'rejetes')->count()
        ];

        return view('admin.moderation', compact('signalements', 'stats'));
    }
    public function traiter(Request $request, $id)
    {
        $signalement = Signalement::findOrFail($id);
        
        $signalement->update([
            'statut' => $request->statut,
            'traitement_description' => $request->description,
            'traitement_date' => now()
        ]);

        return redirect()->back()->with('success', 'Le signalement a été traité avec succès.');
    }
}
