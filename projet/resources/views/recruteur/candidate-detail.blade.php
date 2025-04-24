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
                <!-- Informations de base -->
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

                <!-- Documents -->
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

            <!-- Étapes -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-6">Étapes de recrutement</h2>
                <div class="space-y-6">
                    <!-- Test Technique -->
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

                    <!-- Entretien Oral -->
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

                    <!-- Validation Finale -->
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

            <!-- Modifier le statut -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-6">Modifier le statut</h2>
                <form action="{{ route('recruteur.candidature.status', $candidature->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700">Nouveau statut</label>
                        <select id="statut" name="statut" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="en_attente" @if($candidature->statut === 'en_attente') selected @endif>En attente</option>
                            <option value="acceptée" @if($candidature->statut === 'acceptée') selected @endif>Acceptée</option>
                            <option value="refusée" @if($candidature->statut === 'refusée') selected @endif>Refusée</option>
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

<<!-- Status Change Modal -->
<div id="status-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('recruteur.candidature.status', $candidature->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exchange-alt text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Changer le statut de la candidature
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Candidature de {{ $candidature->candidat->name }}
                                </p>
                                <div class="mt-4">
                                    <label for="new-status" class="block text-sm font-medium text-gray-700">
                                        Nouveau statut
                                    </label>
                                    <select id="new-status" name="statut" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="en_attente" @if($candidature->statut === 'en_attente') selected @endif>En attente</option>
                                        <option value="acceptée" @if($candidature->statut === 'acceptée') selected @endif>Acceptée</option>
                                        <option value="refusée" @if($candidature->statut === 'refusée') selected @endif>Refusée</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="status-note" class="block text-sm font-medium text-gray-700">
                                        Note (optionnelle)
                                    </label>
                                    <textarea id="status-note" name="note" rows="3" 
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                              placeholder="Ajouter une note concernant ce changement de statut..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer
                    </button>
                    <button type="button" id="cancel-status-change" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bouton pour ouvrir la modal
    const changeStatusBtn = document.getElementById('change-status-btn');
    if (changeStatusBtn) {
        changeStatusBtn.addEventListener('click', function() {
            document.getElementById('status-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    // Bouton pour fermer la modal
    const cancelBtn = document.getElementById('cancel-status-change');
    const backdrop = document.getElementById('modal-backdrop');
    if (cancelBtn && backdrop) {
        cancelBtn.addEventListener('click', function() {
            document.getElementById('status-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        backdrop.addEventListener('click', function() {
            document.getElementById('status-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
});
</script>
@endsection
@endsection