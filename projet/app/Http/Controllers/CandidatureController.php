<?php

namespace App\Http\Controllers;

use App\Services\CandidatureService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        try {
            $candidature = $this->service->create($validated);
            return redirect()->route('candidat.applications')->with('success', 'Candidature envoyée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {
            $candidature = $this->service->get($id);
            return view('candidat.application-detail', compact('candidature'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.applications')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $candidature = $this->service->get($id);
            return view('candidat.edit-application', compact('candidature'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.applications')->with('error', $e->getMessage());
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
            return redirect()->route('candidat.applications')->with('success', 'Candidature supprimée avec succès');
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
}