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

        <!-- Hna kayban ghir ila kan lcandidat mqboul -->
        @if($candidature->statut === 'acceptée')
            <!-- Progress bar dial lmasar dial selection -->
            <div class="relative mb-10">
                <!-- Lbar grise li katwri lmasar kammel -->
                <div class="h-2 bg-gray-200 rounded-full w-full absolute top-4"></div>
                <!-- Had flex kaywri les étapes -->
                <div class="flex justify-between relative">
                    <!-- Étape 1: Test technique -->
                    <div class="text-center">
                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto">1</div>
                        <p class="mt-2 font-medium">Test Technique</p>
                    </div>
                    <!-- Étape 2: Entretien - kayban gris ila mazal mavalidach l'étape 1 -->
                    <div class="text-center">
                        <div class="w-10 h-10 bg-{{ $etatpeTestTechnique && $etatpeTestTechnique->statut !== 'en_attente' ? 'blue-500' : 'gray-300' }} text-white rounded-full flex items-center justify-center mx-auto">2</div>
                        <p class="mt-2 font-medium text-{{ $etatpeTestTechnique && $etatpeTestTechnique->statut !== 'en_attente' ? 'black' : 'gray-400' }}">Entretien</p>
                    </div>
                    <!-- Étape 3: Validation - kayban gris ila mazal mavalidach l'étape 2 -->
                    <div class="text-center">
                        <div class="w-10 h-10 bg-{{ $validation ? 'green-500' : 'gray-300' }} text-white rounded-full flex items-center justify-center mx-auto">3</div>
                        <p class="mt-2 font-medium text-{{ $validation ? 'black' : 'gray-400' }}">Validation</p>
                    </div>
                </div>
            </div>

            <!-- Tafasil dial l'étape 1: Test technique -->
            @if($etatpeTestTechnique)
                <div class="mt-8 transform transition-all duration-300 hover:translate-x-1">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2">1</span>
                        Étape 1 - Test Technique
                    </h3>
                    <!-- Card dial test technique - border kaytkoun colored 7sab statut -->
                    <div class="bg-gray-50 p-6 rounded-lg border-l-4 
                        border-{{ $etatpeTestTechnique->statut === 'en_attente' ? 'yellow' : ($etatpeTestTechnique->statut === 'valide' ? 'green' : 'blue') }}-500 
                        shadow-md">
                        <!-- Ila mazal f attente - icon dial loading -->
                        @if($etatpeTestTechnique->statut === 'en_attente')
                            <div class="flex items-center">
                                <svg class="animate-spin h-5 w-5 mr-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-yellow-600 font-medium">En attente de validation</p>
                            </div>
                        <!-- Ila l'étape en cours - kayjib lien dial test -->
                        @elseif($etatpeTestTechnique->statut === 'en_cours')
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
                        <!-- Ila l'étape validée - kayjib message dial félicitations -->
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

                <!-- Tafasil dial l'étape 2: Entretien oral -->
                @if($etapeEntretienOral)
                    <div class="mt-8 transform transition-all duration-300 hover:translate-x-1">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2">2</span>
                            Étape 2 - Entretien Oral
                        </h3>
                        <!-- Card dial entretien - border kaytkoun colored 7sab statut -->
                        <div class="bg-gray-50 p-6 rounded-lg border-l-4 
                            border-{{ $etapeEntretienOral->statut === 'en_attente' ? 'yellow' : ($etapeEntretienOral->statut === 'valide' ? 'green' : 'blue') }}-500 
                            shadow-md">
                            <!-- Ila mazal f attente - icon dial loading -->
                            @if($etapeEntretienOral->statut === 'en_attente')
                                <div class="flex items-center">
                                    <svg class="animate-spin h-5 w-5 mr-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="text-yellow-600 font-medium">En attente de validation</p>
                                </div>
                            <!-- Ila l'étape en cours - kayjib l'adresse dial entretien -->
                            @elseif($etapeEntretienOral->statut === 'en_cours')
                                <div class="mb-4">
                                    <p class="font-semibold text-blue-700 mb-2">Adresse de l'entretien :</p>
                                    <div class="bg-blue-100 text-blue-700 px-4 py-3 rounded-lg flex items-start">
                                        <span class="mr-3 text-xl">📍</span>
                                        <p>{{ $etapeEntretienOral->adresse }}</p>
                                    </div>
                                    <p class="mt-4 text-sm text-gray-500">N'oubliez pas vos documents et soyez à l'heure</p>
                                </div>
                            <!-- Ila l'étape validée - kayjib message dial félicitations -->
                            @elseif($etapeEntretienOral->statut === 'valide')
                                <div class="text-green-600 flex items-start">
                                    <span class="mr-3 mt-1 text-2xl">🎉</span>
                                    <div>
                                        <p class="font-semibold text-lg">Entretien oral réussi !</p>
                                        <p class="mt-2">{{ $etapeEntretienOral->commentaire }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- L3iba lkbira: Validation finale - kada tnajah -->
                    @if($validation)
                        <div class="mt-8 transform transition-all duration-300 hover:scale-102">
                            <h3 class="text-xl font-semibold mb-4 flex items-center">
                                <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center mr-2">3</span>
                                Validation Finale
                            </h3>
                            <!-- Card dial validation finale m3a design special -->
                            <div class="bg-green-50 p-6 rounded-lg border-2 border-green-500 shadow-lg">
                                <div class="text-center">
                                    <!-- Emoji dial ferha -->
                                    <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
                                        <span class="text-5xl">🎊</span>
                                    </div>
                                    <h4 class="text-2xl font-bold text-green-600 mb-4">Félicitations!</h4>
                                    <div class="max-w-md mx-auto">
                                        <p class="text-green-800 text-lg">{{ $validation->commentaire }}</p>
                                    </div>
                                    <div class="mt-6">
                                        <p class="text-gray-600">Bonne chance pour votre nouveau parcours!</p>
                                    </div>
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