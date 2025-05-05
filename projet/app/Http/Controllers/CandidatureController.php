<?php

namespace App\Http\Controllers;

use App\Services\CandidatureService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EtapeTestTechnique;
use App\Models\EtapeValidationFinale;
use App\Models\Candidature;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCandidatureNotification;
use App\Mail\CandidatureStatusNotification;

class CandidatureController extends Controller
{
    protected $service;

    public function __construct(CandidatureService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $candidatures = $this->service->getAll();
        return view('candidat.applications', compact('candidatures'));
    }
    // Afficher toutes les candidatures
    public function candidatures(Request $request)
    {
        $query = Candidature::query()
            ->with(['annonce', 'annonce.recruteur'])
            ->where('candidat_id', auth()->id());

        $statut = $request->query('statut');
        if ($statut) {
            $query->where('statut', $statut);
        }

        $candidatures = $query->paginate(10);

        return view('candidat.applications', compact('candidatures'));
    }

    public function create($annonceId)
    {
        return view('candidat.apply-form', ['annonce_id' => $annonceId]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        try {
            // la one veut gérer le procesus d'upload des cv 
            if($request->hasFile('cv') && $request->file('cv')->isValid()) {
                $validated['cv'] = $request->file('cv')->store('cvs','public');
            }
            $candidature = $this->service->create($validated);
            // Récupérer l'offre et le recruteur
            $offre = $candidature->annonce;
            
            $recruteur = $offre->user;
            
            Mail::to($recruteur->email)->send(
                new NewCandidatureNotification($offre, $recruteur)
            );
            // create etapeTestTechnique & EtapeEntretienOral & EtapeValidationFinale
            $etapeTestTechnique = new EtapeTestTechnique();
            $etapeTestTechnique->candidature_id = $candidature->id;
            $etapeTestTechnique->save();
            $etapeValidationFinale = new EtapeValidationFinale();
            $etapeValidationFinale->candidature_id = $candidature->id;
            $etapeValidationFinale->save();
            return redirect()->route('candidat.candidatures')->with('message', 'Candidature envoyée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage())->withInput();
        }
    }

    // fonction pour telecharger le cv
    public function dowloadcv($id)
    {
        try {
            $candidature = $this->service->get($id);
            if (!$candidature->cv) {
                abort(404);
            }
            return response()->download(storage_path('app/public/' . $candidature->cv));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
    public function show($id)
    {
        // try {
            $candidature = $this->service->get($id);
           
            $etatpeTestTechnique= EtapeTestTechnique::where('candidature_id', $id)->first();
            $Validation = EtapeValidationFinale::where('candidature_id', $id)->first();
            return view('candidat.candidature_detail', compact('candidature','etatpeTestTechnique','Validation'));
        // } catch (\Exception $e) {
        //     return redirect()->route('candidat.candidatures')->with('error', $e->getMessage());
        // }
    }
    public function showrec($id)
    {
        try {
            $candidature = $this->service->get($id);
           
            $etatpeTestTechnique= EtapeTestTechnique::where('candidature_id', $id)->first();
            $Validation = EtapeValidationFinale::where('candidature_id', $id)->first();
            return view('recruteur.candidate-detail', compact('candidature','etatpeTestTechnique','Validation'));
        } catch (\Exception $e) {
            return redirect()->route('recruteur.candidatures')->with('message', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $candidature = $this->service->get($id);
            return view('candidat.edit-application', compact('candidature'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.candidatures')->with('message', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        try {
            $candidature = $this->service->update($id, $validated);
            return redirect()->route('candidat.applications')->with('message', 'Candidature mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('candidat.candidatures')->with('message', 'Candidature supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }


    public function stats()
    {
        $stats = $this->service->getStats();
        return view('admin.stats.candidatures', compact('stats'));
    }

    public function candidaturesByAnnonce($annonceId)
    {
        $candidatures = $this->service->getByAnnonce($annonceId);
        return view('recruteur.candidates', compact('candidatures', 'annonceId'));
    }

    public function candidatApplications()
    {
        $candidatId = auth()->id();
        $candidatures = $this->service->getByCandidat($candidatId);
        return view('candidat.applications', compact('candidatures'));
    }
    // update status of candidature
    public function updateCandidatureStatus(Request $request, $id)
    {
        $candidature = Candidature::findOrFail($id);
        
        $request->validate([
            'statut' => 'required|in:en_attente,acceptée,refusée',
            'commentaire' => 'required_if:statut,acceptée|string',
            'lien_entretien' => 'required_if:statut,acceptée|url',
        ]);

        $candidature->statut = $request->statut;
        $candidature->save();

        // Scénario 1: Refusée
        if ($request->statut === 'refusée') {
            // Créer l'étape de validation finale avec statut refusée
            if (!$candidature->etape_validation_finale) {
                $etapeValidationFinale = new EtapeValidationFinale();
                $etapeValidationFinale->candidature_id = $candidature->id;
                $etapeValidationFinale->statut = 'refusée';
                $etapeValidationFinale->commentaire = 'Nous vous remercions pour votre intérêt, mais votre candidature n\'a pas été retenue cette fois-ci. Nous vous souhaitons bonne chance dans vos futures opportunités.';
                $etapeValidationFinale->save();
            }
        }
        // Scénario 2: Acceptée
        else if ($request->statut === 'acceptée') {
            // Créer l'étape de test technique
            if (!$candidature->etape_test_technique) {
                $etapeTestTechnique = new EtapeTestTechnique();
                $etapeTestTechnique->candidature_id = $candidature->id;
                $etapeTestTechnique->statut = 'en attente';
                $etapeTestTechnique->lien_entretien = $request->lien_entretien;
                $etapeTestTechnique->commentaire = $request->commentaire;
                $etapeTestTechnique->save();
            }
            // Créer l'étape de validation finale (statut initial: en_attente)
            if (!$candidature->etape_validation_finale) {
                $etapeValidationFinale = new EtapeValidationFinale();
                $etapeValidationFinale->candidature_id = $candidature->id;
                $etapeValidationFinale->statut = 'en attente';
                $etapeValidationFinale->save();
            }
        }

        // Envoyer une notification au candidat
        Mail::to($candidature->candidat->email)->send(
            new CandidatureStatusNotification($candidature, $request->statut)
        );

        return redirect()->back()->with('message', 'Statut mis à jour avec succès');
    }
}