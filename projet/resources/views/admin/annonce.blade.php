@extends('layouts.nav')

@section('title', 'Détails de l\'annonce')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ $annonce->titre }}</h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.annonces') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
                <form action="{{ route('admin.annonce.delete', $annonce->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.')">
                        <i class="fas fa-trash mr-2"></i>Supprimer l'annonce
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Détails de l'annonce -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Informations principales -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Informations principales</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-gray-500">Entreprise</div>
                        <div class="text-gray-900 font-medium">{{ $annonce->recruteur->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Type de contrat</div>
                        <div class="text-gray-900 font-medium">{{ $annonce->competences }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Localisation</div>
                        <div class="text-gray-900 font-medium">{{ $annonce->location }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Salaire</div>
                        <div class="text-gray-900 font-medium">{{ number_format($annonce->salaire, 2) }} €</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Statut</div>
                        <div class="text-gray-900 font-medium">
                            <span class="px-3 py-1 text-xs rounded-full 
                                {{ $annonce->statut === 'ouverte' 
                                    ? 'bg-green-100 text-green-800' 
                                    : ($annonce->statut === 'fermee' 
                                        ? 'bg-red-100 text-red-800' 
                                        : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($annonce->statut) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Date de publication</div>
                        <div class="text-gray-900 font-medium">{{ $annonce->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Compétences et tags -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Compétences et tags</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-gray-500">Compétences requises</div>
                        @if($annonce->tags)
                            <div class="flex flex-wrap gap-2">
                                @foreach($annonce->tags as $tag)
                                    <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">{{ $tag->nom }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500">Aucune compétence spécifiée</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Tags</div>
                        @if($annonce->tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($annonce->tags as $tag)
                                    <span class="px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded-full">{{ $tag->nom }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500">Aucun tag associé</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description détaillée -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Description de l'offre</h2>
            <div class="prose max-w-none">
                {!! nl2br(e($annonce->description)) !!}
            </div>
        </div>

        <!-- Candidatures -->
        @if($annonce->candidatures->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Candidatures ({{ $annonce->candidatures->count() }})</h2>
            <div class="space-y-4">
                @foreach($annonce->candidatures as $candidature)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-lg font-medium">{{ $candidature->candidat->name }}</div>
                            <div class="text-sm text-gray-500">{{ $candidature->created_at->format('d/m/Y') }}</div>
                        </div>
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Signaler cette annonce</h2>
                <form action="{{ route('signalements.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="annonce">
                    <input type="hidden" name="id" value="{{ $annonce->id }}">
                    
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
@endsection