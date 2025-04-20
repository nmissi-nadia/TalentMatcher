<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruteurController extends Controller
{
    // Dashboard du recruteur
    public function dashboard()
    {
        $user = Auth::user();
        $annonces = Annonce::where('recruteur_id', $user->id)
            ->withCount('candidatures')
            ->get();

        $stats = [
            'total_annonce' => $annonces->count(),
            'total_candidature' => $annonces->sum('candidatures_count'),
            'active_annonce' => $annonces->where('statut', 'active')->count(),
            'en_attente' => Candidature::whereHas('annonce', function($query) use ($user) {
                $query->where('recruteur_id', $user->id);
            })
            ->where('statut', 'en_attente')
            ->count(),
            'statut_candidatures' => Candidature::whereHas('annonce', function($query) use ($user) {
                    $query->where('recruteur_id', $user->id);
                })
                ->select('statut', DB::raw('count(*) as count'))
                ->groupBy('statut')
                ->get()
                ->mapWithKeys(function($item) {
                    return [$item->statut => $item->count];
                })

        ];
        // Récupérer les candidatures récentes
        $recentCandidatures = Candidature::whereHas('annonce', function($query) use ($user) {
            $query->where('recruteur_id', $user->id);
        })
        ->with(['annonce', 'candidat'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        return view('recruteur.dashboard', compact('annonces', 'stats', 'recentCandidatures'));
    }
    // page des offres
    public function annonces()
    {
        $annonces = Annonce::where('recruteur_id', Auth::id())->get();
        return view('recruteur.offres', compact('annonces'));
    }

    // Créer une nouvelle offre
    public function createAnnonce()
    {
        $tags = Tag::all();
        return view('recruteur.offre-form', compact('tags'));
    }


    // Sauvegarder une nouvelle offre
    public function storeAnnonce(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'required|numeric',
            'tags' => 'required|array'
        ]);

        $annonce = new Annonce([
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary' => $request->salary,
            'status' => 'active'
        ]);

        $user = Auth::user();
        $user->annonces()->save($annonce);
        $annonce->tags()->sync($request->tags);

        return redirect()->route('recruteur.dashboard')->with('success', 'Offre créée avec succès');
    }

    // Gérer les candidatures
    public function manageCandidatures($annonceId)
    {
        $annonce = Annonce::findOrFail($annonceId);
        $this->authorize('view', $annonce);

        $candidatures = $annonce->candidatures()
            ->with('user')
            ->paginate(10);

        return view('recruteur.manage_candidatures', compact('annonce', 'candidatures'));
    }

    // Mettre à jour le statut d'une candidature
    public function updateCandidatureStatus(Request $request, $candidatureId)
    {
        $candidature = Candidature::findOrFail($candidatureId);
        $this->authorize('update', $candidature);

        $request->validate([
            'status' => 'required|in:en_attente,pre_selection,entretien,test_technique,validation_finale,accepte,refuse'
        ]);

        $candidature->status = $request->status;
        $candidature->save();

        return redirect()->back()->with('success', 'Statut mis à jour avec succès');
    }

    // Gérer les étapes de recrutement
    public function manageEtapes($candidatureId)
    {
        $candidature = Candidature::findOrFail($candidatureId);
        $this->authorize('update', $candidature);

        return view('recruteur.manage_etapes', compact('candidature'));
    }

    // Mettre à jour une étape
    public function updateEtape(Request $request, $etapeId)
    {
        $etape = $request->etape_type;
        $model = "App\\Models\\Etape" . ucfirst($etape);

        $record = $model::findOrFail($etapeId);
        $this->authorize('update', $record);

        $record->update($request->all());

        return redirect()->back()->with('success', 'Étape mise à jour avec succès');
    }

    // Statistiques de recrutement
    public function stats()
    {
        $user = Auth::user();
        $stats = [
            'categories' => Annonce::where('user_id', $user->id)
                ->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->get(),
            'statut_candidatures' => Candidature::whereHas('annonce', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get(),
            'temps_moyen' => Candidature::whereHas('annonce', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereNotNull('created_at')
            ->whereNotNull('updated_at')
            ->avg(DB::raw('DATEDIFF(updated_at, created_at)'))
        ];

        return view('recruteur.stats', compact('stats'));
    }

    // Gérer les tags
    public function manageTags()
    {
        $tags = Tag::all();
        return view('recruteur.manage_tags', compact('tags'));
    }

    // Créer un nouveau tag
    public function createTag(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name'
        ]);

        Tag::create($request->all());

        return redirect()->back()->with('success', 'Tag créé avec succès');
    }
}