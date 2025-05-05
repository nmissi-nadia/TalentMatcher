@extends('layouts.nav')

@section('content')
<!-- Container principal -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 border-l-4 border-[#ea480c]">
        <!-- L'en-tête mta3 candidature -->
        <div class="mb-8 transform transition-all duration-300 hover:scale-102">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 flex items-center">
                <span class="mr-2"></span> Détails de la Candidature
            </h2>
            <!-- Separator jmil bach nferqo bin l3anwan o l'contenu -->
            <div class="h-1 w-32 bg-blue-500 rounded-full mb-6"></div>
            
            <!-- Grid dial les informations de base -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre dial l'offre mn database -->
                <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                    <p class="font-semibold text-gray-600">Offre :</p>
                    <p class="text-lg">{{ $candidature->annonce->titre }}</p>
                </div>
                <!-- Date dial candidature formattée -->
                <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                    <p class="font-semibold text-gray-600">Date de Candidature :</p>
                    <p class="text-lg">{{ $candidature->created_at->format('d/m/Y') }}</p>
                </div>
                <!-- Statut dial candidature m3a couleur dynamique -->
                <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                    <p class="font-semibold text-gray-600">Statut :</p>
                    <div class="flex items-center mt-1">
                        <!-- Darna point colored 7sab statut -->
                        <span class="w-3 h-3 rounded-full mr-2 bg-{{ $candidature->statut === 'accepte' ? 'green' : ($candidature->statut === 'refuse' ? 'red' : 'blue') }}-500"></span>
                        <p class="text-{{ $candidature->statut === 'accepte' ? 'green' : ($candidature->statut === 'refuse' ? 'red' : 'blue') }}-600 font-medium">
                            {{ ucfirst($candidature->statut) }}
                        </p>
                    </div>
                </div>
                
                <!-- Lbutton bach iretirer lcandidature -->
                <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                    <p class="font-semibold text-gray-600">Action :</p>
                    <form action="{{ route('candidat.candidatures.delete', $candidature->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="mt-1 bg-white border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white transition-colors duration-300">
                            <span class="mr-1">❌</span> Retirer la candidature
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($candidature->statut === 'en attente')
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Gestion de la candidature</h2>
                <form action="{{ route('recruteur.update.candidature.status', $candidature->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="statut" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="acceptée">Accepter</option>
                                <option value="refusée">Refuser</option>
                            </select>
                        </div>
                        <div class="hidden" id="acceptForm">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lien du test technique</label>
                                <input type="url" name="lien_entretien" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commentaire pour le candidat</label>
                                <textarea name="commentaire" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <script>
                document.querySelector('select[name="statut"]').addEventListener('change', function() {
                    const acceptForm = document.getElementById('acceptForm');
                    acceptForm.style.display = this.value === 'acceptée' ? 'block' : 'none';
                });
            </script>
        @endif
        <!-- Début de la section résultat -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-6">Résultats de la candidature</h2>

            <!-- Affichage du statut de la candidature -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-{{ 
                            ($candidature->statut === 'acceptée') ? 'green-100' : 
                            (($candidature->statut === 'refusée') ? 'red-100' : 'yellow-100') 
                        }} text-{{ 
                            ($candidature->statut === 'acceptée') ? 'green-800' : 
                            (($candidature->statut === 'refusée') ? 'red-800' : 'yellow-800') 
                        }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($candidature->statut === 'acceptée')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                @elseif($candidature->statut === 'refusée')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @endif
                            </svg>
                        </span>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Statut de la candidature
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ ucfirst($candidature->statut) }}
                        </p>
                        @if($candidature->statut === 'acceptée' || $candidature->statut === 'refusée')
                            <p class="mt-2 text-sm text-gray-700">
                                {{ $candidature->commentaire }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            @if($candidature->statut === 'acceptée')
           
                <div class="relative mb-10">
                    <div class="h-2 bg-gray-200 rounded-full w-full absolute top-4"></div>
                    <div class="flex justify-between relative">
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto">1</div>
                            <p class="mt-2 font-medium">Test Technique</p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-{{ $etatpeTestTechnique && $etatpeTestTechnique->statut !== 'en_attente' ? 'blue-500' : 'gray-300' }} text-white rounded-full flex items-center justify-center mx-auto">2</div>
                            <p class="mt-2 font-medium text-{{ $etatpeTestTechnique && $etatpeTestTechnique->statut !== 'en_attente' ? 'black' : 'gray-400' }}">Entretien</p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-{{ $Validation && $Validation->statut !== 'en attente' ? 'green-500' : 'gray-300' }} text-white rounded-full flex items-center justify-center mx-auto">3</div>
                            <p class="mt-2 font-medium text-{{ $Validation && $Validation->statut !== 'en_attente' ? 'black' : 'gray-400' }}">Validation</p>
                        </div>
                    </div>
                </div>

                @if($etatpeTestTechnique)
                    <div class="mt-8 transform transition-all duration-300 hover:translate-x-1">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2">1</span>
                            Étape 1 - Test Technique
                        </h3>
                        <div class="bg-gray-50 p-6 rounded-lg border-l-4 
                            border-{{ $etatpeTestTechnique->statut === 'en attente' ? 'yellow' : ($etatpeTestTechnique->statut === 'valide' ? 'green' : 'blue') }}-500 
                            shadow-md">
                            @if($etatpeTestTechnique->statut === 'en attente')
                                <div class="flex items-center">
                                    <svg class="animate-spin h-5 w-5 mr-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="text-yellow-600 font-medium">En attente de validation</p>
                                </div>
                            @elseif($etatpeTestTechnique->statut === 'en cours')
                                <div class="mb-4">
                                    <p class="font-semibold text-blue-700 mb-2">Lien du test :</p>
                                    <a href="{{ $etatpeTestTechnique->lien_entretien }}" 
                                    target="_blank" 
                                    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg inline-flex items-center hover:bg-blue-200 transition-colors">
                                        <span class="mr-2">🔗</span>
                                        Accéder au test
                                    </a>
                                    <p class="mt-4 text-sm text-gray-500">Le lien s'ouvrira dans un nouvel onglet</p>
                                </div>
                            @elseif($etatpeTestTechnique->statut === 'valide')
                                <div class="text-green-600 flex items-start">
                                    <span class="mr-3 mt-1 text-2xl"></span>
                                    <div>
                                        <p class="font-semibold text-lg">Test technique réussi !</p>
                                        <p class="mt-2">{{ $etatpeTestTechnique->commentaire }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- validation finale -->
                @endif
            @endif
        </div>

    
    </div>
</div>
@endsection