<?php

namespace App\Http\Controllers\Api;

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
        return response()->json($this->service->getAll(), 200);
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
            return response()->json($annonce, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'titre' => 'string|max:255',
            'description' => 'string',
            'statut' => 'in:ouverte,fermée',
        ]);

        try {
            $annonce = $this->service->update($id, $validated);
            return response()->json($annonce, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $annonce = $this->service->delete($id);
            return response()->json($annonce, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStats()
    {
        return response()->json($this->service->getStats(), 200);
    }

    public function getByRecruteur(int $recruteurId)
    {
        return response()->json($this->service->getByRecruteur($recruteurId), 200);
    }

    public function getByStatut(string $statut)
    {
        return response()->json($this->service->getByStatut($statut), 200);
    }

   
}