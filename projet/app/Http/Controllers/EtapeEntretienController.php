<?php

namespace App\Http\Controllers;

use App\Models\EtapeEntretien;
use App\Models\Candidature;
use App\Http\Requests\StoreEtapeEntretienRequest;
use App\Http\Requests\UpdateEtapeEntretienRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtapeEntretienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $this->authorize('viewAny', EtapeEntretien::class);

        $etapes = EtapeEntretien::whereHas('candidature', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['candidature', 'candidature.annonce'])
        ->get();

        return view('recruteur.etapes.index', compact('etapes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($candidatureId)
    {
        $candidature = Candidature::findOrFail($candidatureId);
        $this->authorize('create', [EtapeEntretien::class, $candidature]);

        return view('recruteur.etapes.create', compact('candidature'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEtapeEntretienRequest $request, $candidatureId)
    {
        $candidature = Candidature::findOrFail($candidatureId);
        $this->authorize('create', [EtapeEntretien::class, $candidature]);

        $etape = new EtapeEntretien($request->validated());
        $etape->candidature_id = $candidature->id;
        $etape->save();

        return redirect()->route('recruteur.candidatures.etapes', $candidature->id)
            ->with('success', 'Étape d\'entretien créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(EtapeEntretien $etape)
    {
        $this->authorize('view', $etape);

        return view('recruteur.etapes.show', compact('etape'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EtapeEntretien $etape)
    {
        $this->authorize('update', $etape);

        return view('recruteur.etapes.edit', compact('etape'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEtapeEntretienRequest $request, EtapeEntretien $etape)
    {
        $this->authorize('update', $etape);

        $etape->update($request->validated());

        return redirect()->route('recruteur.candidatures.etapes', $etape->candidature->id)
            ->with('success', 'Étape d\'entretien mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EtapeEntretien $etape)
    {
        $this->authorize('delete', $etape);

        $candidatureId = $etape->candidature->id;
        $etape->delete();

        return redirect()->route('recruteur.candidatures.etapes', $candidatureId)
            ->with('success', 'Étape d\'entretien supprimée avec succès');
    }

    /**
     * Update the status of an interview step.
     */
    public function updateStatus(Request $request, EtapeEntretien $etape)
    {
        $this->authorize('update', $etape);

        $request->validate([
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $etape->statut = $request->statut;
        $etape->save();

        return redirect()->route('recruteur.candidatures.etapes', $etape->candidature->id)
            ->with('success', 'Statut de l\'entretien mis à jour avec succès');
    }

    /**
     * Schedule an interview.
     */
    public function schedule(Request $request, EtapeEntretien $etape)
    {
        $this->authorize('update', $etape);

        $request->validate([
            'date_entretien' => 'required|date|after:now',
            'heure_entretien' => 'required',
            'lieu_entretien' => 'required|string|max:255',
            'type_entretien' => 'required|string|max:255',
            'interviewers' => 'required|array'
        ]);

        $etape->date_entretien = $request->date_entretien;
        $etape->heure_entretien = $request->heure_entretien;
        $etape->lieu_entretien = $request->lieu_entretien;
        $etape->type_entretien = $request->type_entretien;
        $etape->interviewers = json_encode($request->interviewers);
        $etape->statut = 'planifie';
        $etape->save();

        // Send notification to candidate
        $candidature = $etape->candidature;
        $candidat = $candidature->user;

        // TODO: Implement notification system
        // $candidat->notify(new InterviewScheduled($etape));

        return redirect()->route('recruteur.candidatures.etapes', $candidature->id)
            ->with('success', 'Entretien programmé avec succès');
    }

    /**
     * Get interview statistics.
     */
    public function statistics()
    {
        $user = Auth::user();
        $this->authorize('viewAny', EtapeEntretien::class);

        $stats = [
            'total_entretiens' => EtapeEntretien::whereHas('candidature', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
            'entretiens_planifies' => EtapeEntretien::whereHas('candidature', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'planifie')->count(),
            'entretiens_termine' => EtapeEntretien::whereHas('candidature', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'termine')->count(),
            'entretiens_annules' => EtapeEntretien::whereHas('candidature', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('statut', 'annule')->count()
        ];

        return view('recruteur.etapes.statistics', compact('stats'));
    }
}