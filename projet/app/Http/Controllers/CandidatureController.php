<?php

namespace App\Http\Controllers;

use App\Services\CandidatureService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EtapeEntretienOral;
use App\Models\EtapeTestTechnique;
use App\Models\EtapeValidationFinale;
use App\Models\Candidature;

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
            // create etapeTestTechnique & EtapeEntretienOral & EtapeValidationFinale
            $etapeTestTechnique = new EtapeTestTechnique();
            $etapeTestTechnique->candidature_id = $candidature->id;
            $etapeTestTechnique->save();
            $etapeEntretienOral = new EtapeEntretienOral();
            $etapeEntretienOral->candidature_id = $candidature->id;
            $etapeEntretienOral->save();
            $etapeValidationFinale = new EtapeValidationFinale();
            $etapeValidationFinale->candidature_id = $candidature->id;
            $etapeValidationFinale->save();
            return redirect()->route('candidat.candidatures')->with('success', 'Candidature envoyée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
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
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function show($id)
    {
        // try {
            $candidature = $this->service->get($id);
           
            $etatpeEntretienOral= EtapeEntretienOral::where('candidature_id', $id)->first();
       
            $etatpeTestTechnique= EtapeTestTechnique::where('candidature_id', $id)->first();
            $Validation = EtapeValidationFinale::where('candidature_id', $id)->first();
            return view('candidat.candidature_detail', compact('candidature','etatpeEntretienOral','etatpeTestTechnique','Validation'));
        // } catch (\Exception $e) {
        //     return redirect()->route('candidat.candidatures')->with('error', $e->getMessage());
        // }
    }
    public function showrec($id)
    {
        try {
            $candidature = $this->service->get($id);
           
            $etatpeEntretienOral= EtapeEntretienOral::where('candidature_id', $id)->first();
            $etatpeTestTechnique= EtapeTestTechnique::where('candidature_id', $id)->first();
            $Validation = EtapeValidationFinale::where('candidature_id', $id)->first();
            return view('recruteur.candidate-detail', compact('candidature','etatpeEntretienOral','etatpeTestTechnique','Validation'));
        } catch (\Exception $e) {
            return redirect()->route('recruteur.candidatures')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $candidature = $this->service->get($id);
            return view('candidat.edit-application', compact('candidature'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.candidatures')->with('error', $e->getMessage());
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
            return redirect()->route('candidat.applications')->with('success', 'Candidature mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('candidat.candidatures')->with('success', 'Candidature supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        try {
            $candidature = $this->service->update($id, ['statut' => $validated['statut']]);
            return redirect()->back()->with('success', 'Statut de la candidature mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
    $this->authorize('update', $candidature);

    $request->validate([
        'statut' => 'required|in:en attente,acceptée,refusée'
    ]);

    $currentStatus = $candidature->statut;
    $newStatus = $request->statut;
    $candidature->statut = $newStatus;
    $candidature->save();

    switch ($newStatus) {
        case 'acceptée':
            if (!$candidature->etape_entretien_oral) {
                $etapeEntretienOral = new EtapeEntretienOral();
                $etapeEntretienOral->candidature_id = $candidature->id;
                $etapeEntretienOral->save();
            }
            break;

        case 'refusée':
            if (!$candidature->etape_validation_finale) {
                $etapeValidationFinale = new EtapeValidationFinale();
                $etapeValidationFinale->candidature_id = $candidature->id;
                $etapeValidationFinale->statut = 'refusée';
                $etapeValidationFinale->save();
            }
            break;

        
            
            break;
    }

    return redirect()->back()->with('success', 'Statut mis à jour avec succès');
}
}