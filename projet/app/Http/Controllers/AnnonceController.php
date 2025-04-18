<?php

namespace App\Http\Controllers;

use App\Services\AnnonceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AnnonceRepositoryInterface;

class AnnonceController extends Controller
{
    protected $service;

    public function __construct(AnnonceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $annonces = $this->service->getAll();
        return view('candidat.jobs', compact('annonces'));
    }

    public function show($id)
    {
        try {
            $annonce = $this->service->get($id);
            return view('candidat.job-detail', compact('annonce'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.jobs')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('recruteur.job-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:ouverte,fermée',
        ]);

        try {
            $annonce = $this->service->create($validated);
            return redirect()->route('recruteur.jobs')->with('success', 'Annonce créée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $annonce = $this->service->get($id);
            return view('recruteur.job-form', compact('annonce'));
        } catch (\Exception $e) {
            return redirect()->route('recruteur.jobs')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'string|max:255',
            'description' => 'string',
            'statut' => 'in:ouverte,fermée',
        ]);

        try {
            $annonce = $this->service->update($id, $validated);
            return redirect()->route('recruteur.jobs')->with('success', 'Annonce mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('recruteur.jobs')->with('success', 'Annonce supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stats()
    {
        $stats = $this->service->getStats();
        return view('admin.stats.annonces', compact('stats'));
    }

    public function recruteurAnnonces()
    {
        $recruteurId = auth()->id();
        $annonces = $this->service->getByRecruteur($recruteurId);
        return view('recruteur.jobs', compact('annonces'));
    }

    public function statutAnnonces($statut)
    {
        $annonces = $this->service->getByStatut($statut);
        return view('candidat.jobs', compact('annonces'));
    }
}