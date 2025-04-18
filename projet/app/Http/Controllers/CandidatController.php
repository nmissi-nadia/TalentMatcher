<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidature;
use App\Models\Annonce;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class CandidatController extends Controller
{
    // Afficher le profil du candidat
    public function showProfile()
    {
        $user = Auth::user();
        $candidatures = Candidature::where('user_id', $user->id)->get();
        return view('candidat.profile', compact('user', 'candidatures'));
    }

    // Mettre à jour le profil
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:2048'
        ]);

        $user = Auth::user();
        $user->update($request->except('cv_file'));

        if ($request->hasFile('cv_file')) {
            $path = $request->file('cv_file')->store('cv', 'public');
            $user->cv_path = $path;
            $user->save();
        }

        return redirect()->route('candidat.profile')->with('success', 'Profil mis à jour avec succès');
    }

    // Rechercher des offres d'emploi
    public function search(Request $request)
    {
        $query = Annonce::query();

        // Filtrer par catégorie
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filtrer par localisation
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filtrer par mots-clés
        if ($request->has('keywords')) {
            $query->where('title', 'like', '%' . $request->keywords . '%')
                  ->orWhere('description', 'like', '%' . $request->keywords . '%');
        }

        // Filtrer par tags
        if ($request->has('tags')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->whereIn('tags.id', $request->tags);
            });
        }

        $annonces = $query->with('tags')->paginate(10);

        return view('candidat.search', compact('annonces'));
    }

    // Postuler à une offre
    public function apply(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();

        // Vérifier si le candidat a déjà postulé
        $existingCandidature = Candidature::where('user_id', $user->id)
            ->where('annonce_id', $id)
            ->first();

        if ($existingCandidature) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre');
        }

        $candidature = new Candidature([
            'user_id' => $user->id,
            'annonce_id' => $id,
            'status' => 'en_attente',
            'message' => $request->message ?? null
        ]);

        $candidature->save();

        return redirect()->route('candidat.candidatures')->with('success', 'Candidature envoyée avec succès');
    }

    // Afficher toutes les candidatures
    public function candidatures()
    {
        $user = Auth::user();
        $candidatures = Candidature::where('user_id', $user->id)
            ->with('annonce')
            ->paginate(10);

        return view('candidat.candidatures', compact('candidatures'));
    }

    // Supprimer une candidature
    public function deleteCandidature($id)
    {
        $candidature = Candidature::findOrFail($id);
        $this->authorize('delete', $candidature);
        $candidature->delete();

        return redirect()->route('candidat.candidatures')->with('success', 'Candidature supprimée');
    }

    // Afficher les offres recommandées
    public function recommended()
    {
        $user = Auth::user();
        $tags = $user->tags;
        $annonces = Annonce::whereHas('tags', function($q) use ($tags) {
            $q->whereIn('tags.id', $tags->pluck('id'));
        })
        ->with('tags')
        ->paginate(10);

        return view('candidat.recommended', compact('annonces'));
    }
}