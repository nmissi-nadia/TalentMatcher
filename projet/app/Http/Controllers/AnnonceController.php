<?php

namespace App\Http\Controllers;

use App\Services\AnnonceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AnnonceRepositoryInterface;
use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Tag;

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
        return view('candidat.offres', compact('annonces'));
    }

    public function show($id)
    {
        try {
            $offre = $this->service->get($id);
            return view('candidat.offre-detail', compact('offre'));
        } catch (\Exception $e) {
            return redirect()->route('candidat.offres')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('recruteur.offre-form');
    }

    // les offres existes
    public function offres(Request $request)
    {
        $query = Annonce::query();
        
        if ($request->filled('category')) {
            $query->where('categorie_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('keywords')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                  ->orWhere('description', 'like', '%' . $request->keywords . '%')
                  ->orWhereHas('tags', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->keywords . '%');
                  });
            });
        }

        if ($request->filled('tags')) {
            $tagIds = is_array($request->tags) ? $request->tags : [$request->tags];
            $query->whereHas('tags', function($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        if ($request->filled('status')) {
            $query->where('statut', $request->status);
        }

        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $offres = $query->with(['recruteur', 'tags', 'categorie'])->paginate(10);
        $categories = Categorie::all();
        $tags = Tag::all();

        return view('candidat.offres', compact('offres', 'categories', 'tags'));
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
            return redirect()->route('recruteur.offres')->with('success', 'Annonce créée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $annonce = $this->service->get($id);
            return view('recruteur.offre-form', compact('annonce'));
        } catch (\Exception $e) {
            return redirect()->route('recruteur.offres')->with('error', $e->getMessage());
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
            return redirect()->route('recruteur.offres')->with('success', 'Annonce mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('recruteur.offres')->with('success', 'Annonce supprimée avec succès');
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
        return view('recruteur.offres', compact('annonces'));
    }

    public function statutAnnonces($statut)
    {
        $annonces = $this->service->getByStatut($statut);
        return view('candidat.offres', compact('annonces'));
    }
}