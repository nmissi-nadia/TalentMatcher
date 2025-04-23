<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Tag;
use App\Models\Categorie;
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
        $categories = Categorie::all();
        return view('recruteur.offre-form', compact('tags', 'categories'));
    }


    // Sauvegarder une nouvelle offre
    public function storeAnnonce(Request $request)
        {
            try {
                $validated = $request->validate([
                    'titre' => 'required|string|max:255',
                    'categorie_id' => 'required|exists:categories,id',
                    'location' => 'required|string',
                    'description' => 'required|string',
                    'competences' => 'required|string',
                    'salaire' => 'required|numeric',
                    'tags' => 'required|array',
                    'tags.*' => 'exists:tags,id',
                    'statut' => 'required|in:ouverte,fermée'
                ]);

                $data = array_merge($validated, [
                    'recruteur_id' => Auth::id()
                ]);

                // Créons l'annonce étape par étape
                $annonce = new Annonce();
                $annonce->titre = $data['titre'];
                $annonce->description = $data['description'];
                $annonce->location = $data['location'];
                $annonce->competences = $data['competences'];
                $annonce->salaire = $data['salaire'];
                $annonce->categorie_id = $data['categorie_id'];
                $annonce->recruteur_id = $data['recruteur_id'];
                $annonce->statut = $data['statut'];
                
                // Sauvegardons l'annonce
                $annonce->save();

                // Associer les tags
                if ($request->has('tags')) {
                    $annonce->tags()->sync($request->tags);
                }

                return redirect()->route('recruteur.dashboard')
                    ->with('success', 'Offre créée avec succès');

            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($e->errors())
                    ->with('error', 'Veuillez corriger les erreurs dans le formulaire');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Erreur lors de la création de l\'offre: ' . $e->getMessage());
            }
        }

    // Gérer les candidatures
    public function Candidatures($annonceId)
    {
        $annonce = Annonce::findOrFail($annonceId);
        $this->authorize('view', $annonce);

        $candidatures = $annonce->candidatures()
            ->with('user')
            ->paginate(10);

        return view('recruteur.candidates', compact('candidatures'));
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

   
}