<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidature;
use App\Models\Annonce;
use App\Models\Tag;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;

class CandidatController extends Controller
{
    // dashboard d candidat
    public function dashboard()
    {
        $user = Auth::user();
        $activeoffres = Annonce::where('statut', 'active')->count();
        $candidatures = Candidature::where('candidat_id', Auth::id())->get();
        return view('candidat.dashboard', compact('candidatures', 'activeoffres'));
    }
    // Afficher le profil du candidat
    public function showProfile()
    {
        $user = Auth::user();
        $candidatures = Candidature::where('candidat_id', $user->id)->get();
        return view('candidat.profil', compact('user', 'candidatures'));
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
            $path = $request->file('cv_file')->store('cvs', 'public');
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
    // les offres existes
    public function offres()
    {
            $offres = Annonce::with(['recruteur', 'tags', 'categorie'])
            ->paginate(10);
            
        $categories = Categorie::all();
        $tags = Tag::all();
        
        return view('candidat.offres', compact('offres', 'categories', 'tags'));
    }

    // Postuler à une offre
    public function apply(Request $request, $id)
    {
        // Récupérer l'offre
        $offre = Annonce::with('candidatures')->findOrFail($id);
        
        // Vérifier si le candidat est connecté
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Veuillez vous connecter pour postuler');
        }

        // Vérifier si le candidat a déjà postulé
        if ($offre->candidatures()->where('candidat_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre');
        }

        // Vérifier si l'offre est ouverte
        if ($offre->statut !== 'ouverte') {
            return redirect()->back()->with('error', 'Cette offre n\'est plus ouverte aux candidatures');
        }

        // Validation des données
        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Créer la candidature
        $candidature = new Candidature([
            'annonce_id' => $offre->id,
            'candidat_id' => Auth::id(),
            'lettre_motivation' => $validated['message'] ?? null,
            'statut' => 'en attente',

        ]);

        // Sauvegarder le CV
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $candidature->cv = $cvPath;
        }

        $candidature->save();

        // Envoyer une notification au recruteur
        // $offre->recruteur->notify(new NouvelleCandidature($candidature));

        return redirect()->route('candidat.candidatures')
            ->with('success', 'Candidature envoyée avec succès');
    }

    // Afficher toutes les candidatures
    public function candidatures()
    {
        $user = Auth::user();
        $candidatures = Candidature::where('candidat_id', $user->id)
            ->with('annonce')
            ->paginate(10);

        return view('candidat.applications', compact('candidatures'));
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