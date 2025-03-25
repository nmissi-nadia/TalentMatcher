<?php

namespace App\Http\Controllers\Api;

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
        return response()->json($this->service->getAll(), 200);
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
            return response()->json($candidature, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        try {
            $candidature = $this->service->update($id, $validated);
            return response()->json($candidature, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $candidature = $this->service->delete($id);
            return response()->json($candidature, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStats()
    {
        return response()->json($this->service->getStats(), 200);
    }

    public function getByAnnonce(int $annonceId)
    {
        return response()->json($this->service->getByAnnonce($annonceId), 200);
    }

    public function getByCandidat(int $candidatId)
    {
        return response()->json($this->service->getByCandidat($candidatId), 200);
    }

    public function getByAnnonceAndCandidat(int $annonceId, int $candidatId)
    {
        return response()->json($this->service->getByAnnonceAndCandidat($annonceId, $candidatId), 200);
    }
}