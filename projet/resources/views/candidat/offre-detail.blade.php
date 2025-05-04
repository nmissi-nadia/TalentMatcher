@extends('layouts.nav')

@section('title', $offre->titre)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('candidat.offres') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux offres
            </a>
        </div>
        <div class="flex items-center space-x-4">
            @if(Auth::check())
                @if(!$offre->candidatures()->where('candidat_id', Auth::id())->exists() && $offre->statut === 'ouverte')
                    <button onclick="document.getElementById('postulationModal').showModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Postuler
                    </button>
                @endif
            @endif
        </div>
    </div>

    <!-- offre Details Section -->
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-start">
                @if($offre->recruteur->logo)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $offre->recruteur->logo) }}" alt="{{ $offre->recruteur->name }}" class="w-16 h-16 rounded-lg object-cover">
                    </div>
                @else
                    <div class="flex-shrink-0 h-16 w-16 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                @endif
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $offre->titre }}</h1>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-building mr-1.5"></i>
                        <a href="#" class="hover:text-blue-600">
                            {{ $offre->recruteur->name }}
                        </a>
                    </div>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1.5"></i>
                        <span>{{ $offre->location }}</span>
                    </div>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock mr-1.5"></i>
                        <span>{{ $offre->type_contrat }}</span>
                    </div>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-euro-sign mr-1.5"></i>
                        <span>{{ number_format($offre->salaire, 2) }} €</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
                <span class="px-2 py-1 text-xs rounded-full {{ $offre->statut === 'ouverte' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($offre->statut) }}
                </span>
                <span class="text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    {{ $offre->created_at->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <!-- Description -->
        <div class="p-6 border-t border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Description du poste</h2>
            <div class="prose prose-blue max-w-none">
                {!! nl2br(e($offre->description)) !!}
            </div>
        </div>

        <!-- Missions et Responsabilités -->
        @if($offre->missions)
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Missions et responsabilités</h3>
            <div class="space-y-2">
                @foreach(explode("\n", $offre->missions) as $mission)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check text-blue-600 mr-2"></i>
                        </div>
                        <p class="text-gray-700">{{ $mission }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Compétences requises -->
        @if($offre->tags->isNotEmpty())
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Compétences requises</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($offre->tags as $tag)
                    <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                        {{ $tag->nom }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Profil recherché -->
        @if($offre->profil_recherche)
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Profil recherché</h3>
            <div class="space-y-2">
                @foreach(explode("\n", $offre->profil_recherche) as $profil)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                        </div>
                        <p class="text-gray-700">{{ $profil }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Avantages -->
        @if($offre->avantages)
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Avantages</h3>
            <div class="space-y-2">
                @foreach(explode("\n", $offre->avantages) as $avantage)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-gift text-blue-600 mr-2"></i>
                        </div>
                        <p class="text-gray-700">{{ $avantage }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Candidatures -->
        @if(Auth::check())
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut de votre candidature</h3>
            @if($offre->candidatures()->where('candidat_id', Auth::id())->exists())
                @php
                    $candidature = $offre->candidatures()->where('candidat_id', Auth::id())->first();
                @endphp
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                Votre candidature a bien été reçue
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Date de postulation : {{ $candidature->created_at->format('d/m/Y') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Statut : {{ ucfirst($candidature->statut) }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">
                        Vous n'avez pas encore postulé à cette offre
                    </p>
                </div>
            @endif
        </div>
        @endif

        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Partager cette offre</h3>
            <div class="flex space-x-4">
                <a href="javascript:void(0)" onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($offre->titre . ' - ' . $offre->recruteur->name) }}', '_blank', 'width=600,height=400')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fab fa-twitter mr-2"></i>
                    Twitter
                </a>
                <a href="javascript:void(0)" onclick="window.open('https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}', '_blank', 'width=600,height=400')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fab fa-linkedin-in mr-2"></i>
                    LinkedIn
                </a>
            </div>
        </div>
        
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Signaler cette annonce</h2>
                    <form action="{{ route('signalements.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="annonce">
                        <input type="hidden" name="id" value="{{ $offre->id }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Motif du signalement</label>
                            <select name="motif" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Sélectionnez un motif</option>
                                <option value="contenu_inapproprie">Contenu inapproprié</option>
                                <option value="faux_profil">Faux profil</option>
                                <option value="spam">Spam</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description (optionnel)</label>
                            <textarea name="description" rows="3" class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Envoyer le signalement
                        </button>
                    </form>
                </div>
            </div>
        
    </div>
</div>

<!-- Modal de postulation -->
<dialog id="postulationModal" class="modal">
    <form method="POST" action="{{ route('candidat.apply', $offre->id) }}" class="modal-box bg-white rounded-lg shadow-xl p-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <!-- Header -->
        <input type="hidden" name="offre_id" value="{{ $offre->id }}">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-xl text-gray-800">Postuler à {{ $offre->titre }}</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('postulationModal').close()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="text-gray-600">Veuillez remplir les informations suivantes pour postuler à cette offre.</p>

        <!-- Message de motivation -->
        <div class="form-control">
            <label class="label">
                <span class="label-text text-gray-700">Message de motivation (optionnel)</span>
            </label>
            <textarea name="message" class="textarea textarea-bordered h-28 border-gray-300 focus:ring focus:ring-blue-200 rounded-md" placeholder="Votre message de motivation..."></textarea>
        </div>

        <!-- CV Upload -->
        <div class="form-control">
            <label class="label">
                <span class="label-text text-gray-700">CV (PDF, DOC, DOCX)</span>
            </label>
            <input type="file" name="cv" class="file-input file-input-bordered w-full border-gray-300 focus:ring focus:ring-blue-200 rounded-md" required>
        </div>

        <!-- Actions -->
        <div class="modal-action flex justify-end space-x-3">
            <button type="button" class="btn btn-ghost text-gray-600 hover:bg-gray-100" onclick="document.getElementById('postulationModal').close()">Annuler</button>
            <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2">Envoyer ma candidature</button>
        </div>
    </form>
</dialog>


<!-- Scripts -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la fermeture du modal quand on clique en dehors
    const modal = document.getElementById('postulationModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.close();
        }
    });

    // Validation du format du CV
    const cvInput = document.querySelector('input[name="cv"]');
    cvInput.addEventListener('change', function() {
        const file = this.files[0];
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (!allowedTypes.includes(file.type)) {
            alert('Veuillez sélectionner un fichier PDF, DOC ou DOCX.');
            this.value = '';
        }
    });

    // Smooth scroll pour les liens internes
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>
@endsection
</div>
@endsection