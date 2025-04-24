@extends('layouts.nav')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Informations de base de la candidature -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Détails de la Candidature</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="font-semibold">Offre :</p>
                    <p>{{ $candidature->annonce->titre }}</p>
                </div>
                <div>
                    <p class="font-semibold">Date de Candidature :</p>
                    <p>{{ $candidature->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="font-semibold">Statut :</p>
                    <p class="text-{{ $candidature->statut === 'accepte' ? 'green' : ($candidature->statut === 'refuse' ? 'red' : 'blue') }}-600">
                        {{ ucfirst($candidature->statut) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Affichage conditionnel des étapes -->
        @if($candidature->statut === 'accepte')
            @if($candidature->testTechnique)
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-4">Étape 1 - Test Technique</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @if($candidature->testTechnique->statut === 'en_attente')
                            <p class="text-yellow-600">En attente de validation</p>
                        @elseif($candidature->testTechnique->statut === 'en_cours')
                            <div class="mb-4">
                                <p class="font-semibold">Lien du test :</p>
                                <a href="{{ $candidature->testTechnique->lien_entretien }}" 
                                   target="_blank" 
                                   class="text-blue-600 hover:text-blue-800">
                                    {{ $candidature->testTechnique->lien_entretien }}
                                </a>
                            </div>
                        @elseif($candidature->testTechnique->statut === 'valide')
                            <div class="text-green-600">
                                <p class="font-semibold">Test technique réussi !</p>
                                <p>{{ $candidature->testTechnique->commentaire }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($candidature->entretienOral)
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-4">Étape 2 - Entretien Oral</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($candidature->entretienOral->statut === 'en_attente')
                                <p class="text-yellow-600">En attente de validation</p>
                            @elseif($candidature->entretienOral->statut === 'en_cours')
                                <div class="mb-4">
                                    <p class="font-semibold">Adresse de l'entretien :</p>
                                    <p>{{ $candidature->entretienOral->adresse }}</p>
                                </div>
                            @elseif($candidature->entretienOral->statut === 'valide')
                                <div class="text-green-600">
                                    <p class="font-semibold">Entretien oral réussi !</p>
                                    <p>{{ $candidature->entretienOral->commentaire }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($candidature->validation)
                        <div class="mt-6">
                            <h3 class="text-xl font-semibold mb-4">Validation Finale</h3>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-center">
                                    <h4 class="text-2xl font-bold text-green-600 mb-4">Félicitations !</h4>
                                    <p class="text-green-800">{{ $candidature->validation->commentaire }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        @endif
    </div>
</div>
@endsection