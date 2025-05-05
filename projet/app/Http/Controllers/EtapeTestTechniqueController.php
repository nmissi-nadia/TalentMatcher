<?php

namespace App\Http\Controllers;

use App\Models\EtapeTestTechnique;
use App\Http\Requests\StoreEtapeTestTechniqueRequest;
use App\Http\Requests\UpdateEtapeTestTechniqueRequest;

class EtapeTestTechniqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEtapeTestTechniqueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EtapeTestTechnique $etapeTestTechnique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EtapeTestTechnique $etapeTestTechnique)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$candidatureId)
    {
        $candidature = Candidature::with('etape_test_technique')->findOrFail($candidatureId);
        $etape = $candidature->etape_test_technique;

        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,terminé,refusé',
            'commentaire' => 'nullable|string',
            'note' => 'nullable|numeric|min:0|max:20'
        ]);

        $etape->update($request->all());

        // Si le test est terminé et réussi, passer à l'étape de validation finale
        if ($request->statut === 'terminé' && $request->note >= 12) {
            if (!$candidature->etape_validation_finale) {
                $etapeValidationFinale = new EtapeValidationFinale();
                $etapeValidationFinale->candidature_id = $candidature->id;
                $etapeValidationFinale->statut = 'acceptée';
                $etapeValidationFinale->save();

                // Envoyer une notification au candidat
                Mail::to($candidature->candidat->email)->send(
                    new TestTechniqueSuccessNotification($candidature)
                );
            }
        }

        return redirect()->back()->with('message', 'Étape mise à jour avec succès');
    
    }
    public function updateStatus(Request $request, $candidatureId)
        {
            $candidature = Candidature::with('etape_test_technique')->findOrFail($candidatureId);
            $etape = $candidature->etape_test_technique;

            $request->validate([
                'statut' => 'required|in:en attente,accepté,refusé',
                'commentaire' => 'nullable|string',
            ]);

            // Mettre à jour le statut du test
            $etape->statut = $request->statut;
            $etape->commentaire = $request->commentaire;
            $etape->save();

            // Si le test est terminé
            if ($request->statut === 'accepté') {
                $etapeValidationFinale = $candidature->etape_validation_finale;
                    $etapeValidationFinale->statut = 'acceptée';
                    $etapeValidationFinale->commentaire = 'Félicitations ! Vous avez réussi le test technique et votre candidature est acceptée.';
            } elseif ($request->statut === 'refusé') {
                $etapeValidationFinale = $candidature->etape_validation_finale;
                    $etapeValidationFinale->statut = 'refusée';
                    $etapeValidationFinale->commentaire = 'Nous avons le regret de vous informer que votre test technique n\'a pas été réussi.';
            }
                $etapeValidationFinale->save();

                // Envoyer une notification au candidat
                Mail::to($candidature->candidat->email)->send(
                    new UpdateStatusNotification($candidature, $request->statut)
                );
            

            return redirect()->back()->with('message', 'Statut du test mis à jour avec succès');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EtapeTestTechnique $etapeTestTechnique)
    {
        //
    }
}
