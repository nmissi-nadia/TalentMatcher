@extends('layouts.nav')

@section('title', $offre->titre . ' - TalentMatcher')

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
                    <button onclick="document.location='{{ route('candidat.apply', $offre->id) }}'" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                <div class="flex-shrink-0 h-12 w-12 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-briefcase text-lg"></i>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $offre->titre }}</h1>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-building mr-1.5"></i>
                        <span>{{ $offre->recruteur->name }}</span>
                    </div>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1.5"></i>
                        <span>{{ $offre->location }}</span>
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
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Description du poste</h2>
            <div class="prose prose-blue max-w-none">
                {!! nl2br(e($offre->description)) !!}
            </div>
        </div>

        <!-- Tags -->
        @if($offre->tags->isNotEmpty())
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Compétences requises</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($offre->tags as $tag)
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                        {{ $tag->nom }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Catégorie -->
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Domaine d'activité</h3>
            <div class="flex items-center">
                <i class="fas fa-tag mr-2 text-blue-500"></i>
                <span class="text-gray-700">{{ $offre->categorie->nom }}</span>
            </div>
        </div>

        <!-- Candidatures -->
        @if(Auth::check())
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut de votre candidature</h3>
            @if($offre->candidatures()->where('candidat_id', Auth::id())->exists())
                @php
                    $candidature = $offre->candidatures()->where('candidat_id', Auth::id())->first();
                @endphp
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-700">
                            Vous avez postulé à cette offre le {{ $candidature->created_at->format('d/m/Y') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Statut : {{ ucfirst($candidature->statut) }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-600">
                    Vous n'avez pas encore postulé à cette offre
                </p>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter un effet de survol sur les boutons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection