@extends('layouts.nav')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Détails de la candidature
                </h2>
                <div class="flex space-x-2">
                    <a href="{{ route('recruteur.candidatures.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#ea480c] hover:bg-[#d44a0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ea480c]">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
               
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-4">Informations de base</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Candidat</p>
                            <p class="text-sm text-gray-900">{{ $candidature->candidat->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Offre d'emploi</p>
                            <p class="text-sm text-gray-900">{{ $candidature->annonce->titre }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de candidature</p>
                            <p class="text-sm text-gray-900">{{ $candidature->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Statut actuel</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($candidature->statut === 'acceptée') bg-green-100 text-green-800
                                @elseif($candidature->statut === 'refusée') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($candidature->statut) }}
                            </span>
                        </div>
                    </div>
                </div>

               
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-4">Documents</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Lettre de motivation</p>
                            <p class="text-sm text-gray-900">
                                @if($candidature->lettre_motivation)
                                    <a href="{{ asset('storage/' . $candidature->lettre_motivation) }}" 
                                       class="text-blue-600 hover:text-blue-800" 
                                       target="_blank">
                                        Voir la lettre
                                    </a>
                                @else
                                    Non fournie
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CV</p>
                            <p class="text-sm text-gray-900">
                                @if($candidature->cv)
                                    <a href="{{ asset('storage/' . $candidature->cv) }}" 
                                       class="text-blue-600 hover:text-blue-800" 
                                       target="_blank">
                                        Voir le CV
                                    </a>
                                @else
                                    Non fourni
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-6">Étapes de recrutement</h2>
                <div class="space-y-6">
                    @if($etatpeTestTechnique)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium mb-4">Test Technique</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($etatpeTestTechnique->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($etatpeTestTechnique->statut === 'en_cours') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($etatpeTestTechnique->statut) }}
                                    </span>
                                </div>
                                @if($etatpeTestTechnique->statut === 'en_cours')
                                    <div>
                                        <p class="text-sm text-gray-500">Lien du test</p>
                                        <a href="{{ $etatpeTestTechnique->lien_entretien }}" 
                                           class="text-blue-600 hover:text-blue-800" 
                                           target="_blank">
                                            {{ $etatpeTestTechnique->lien_entretien }}
                                        </a>
                                    </div>
                                @endif
                                @if($etatpeTestTechnique->commentaire)
                                    <div>
                                        <p class="text-sm text-gray-500">Commentaire</p>
                                        <p class="text-sm text-gray-900">{{ $etatpeTestTechnique->commentaire }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($etatpeEntretienOral)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium mb-4">Entretien Oral</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($etatpeEntretienOral->statut === 'en attente') bg-yellow-100 text-yellow-800
                                        @elseif($etatpeEntretienOral->statut === 'en cours') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($etatpeEntretienOral->statut) }}
                                    </span>
                                </div>
                                @if($etatpeEntretienOral->statut === 'en_cours')
                                    <div>
                                        <p class="text-sm text-gray-500">Adresse</p>
                                        <p class="text-sm text-gray-900">{{ $etatpeEntretienOral->adresse }}</p>
                                    </div>
                                @endif
                                @if($etatpeEntretienOral->commentaire)
                                    <div>
                                        <p class="text-sm text-gray-500">Commentaire</p>
                                        <p class="text-sm text-gray-900">{{ $etatpeEntretienOral->commentaire }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($Validation)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium mb-4">Validation Finale</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($Validation->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($Validation->statut === 'en_cours') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($Validation->statut) }}
                                    </span>
                                </div>
                                @if($Validation->commentaire)
                                    <div>
                                        <p class="text-sm text-gray-500">Commentaire</p>
                                        <p class="text-sm text-gray-900">{{ $Validation->commentaire }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-6">Modifier le statut</h2>
                <form action="{{ route('recruteur.candidature.status', $candidature->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700">Nouveau statut</label>
                        <select id="statut" name="statut" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="en attente" @if($candidature->statut === 'en attente') selected @endif>En attente</option>
                            <option value="acceptée" @if($candidature->statut === 'accepté') selected @endif>Accepté</option>
                            <option value="refusée" @if($candidature->statut === 'refusé') selected @endif>Refusé</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#ea480c] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection