@extends('layouts.nav')

@section('title', isset($offre) ? 'Modifier une offre - TalentMatcher' : 'Créer une offre - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ isset($offre) ? 'Modifier l\'offre d\'emploi' : 'Publier une nouvelle offre d\'emploi' }}
        </h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ isset($offre) ? route('recruteur.updateAnnonce', $offre->id) : route('recruteur.annonces.store') }}" method="POST" class="space-y-6 px-4 py-5 sm:p-6">
                @csrf
                @if(isset($offre))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                    <!-- Hidden offre ID for edit mode -->
                    @if(isset($offre))
                        <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                    @endif
                    
                    <!-- Titre -->
                    <div class="sm:col-span-6">
                        <label for="titre" class="block text-sm font-medium text-gray-700">
                            Titre du poste <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" id="titre" name="titre" value="{{ old('titre', isset($offre) ? $offre->titre : '') }}" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('titre') border-red-500 @enderror"
                                placeholder="ex: Développeur Full Stack JavaScript">
                        </div>
                        @error('titre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Un titre clair et concis qui décrit le poste (Max. 100 caractères)
                        </p>
                    </div>

                    <!-- Catégorie -->
                    <div class="sm:col-span-3">
                        <label for="categorie_id" class="block text-sm font-medium text-gray-700">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="categorie_id" name="categorie_id" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('categorie_id') border-red-500 @enderror">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id', isset($offre) ? $offre->categorie_id : '') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('categorie_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="sm:col-span-3">
                        <label for="location" class="block text-sm font-medium text-gray-700">
                            Lieu <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" id="location" name="location" value="{{ old('location', isset($offre) ? $offre->location : '') }}" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('location') border-red-500 @enderror"
                                placeholder="ex: Paris, France">
                        </div>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description du poste <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="5" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-500 @enderror"
                                placeholder="Décrivez les responsabilités et le contexte du poste...">{{ old('description', isset($offre) ? $offre->description : '') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Décrivez les principales responsabilités et le contexte du poste
                        </p>
                    </div>

                    <!-- Compétences -->
                    <div class="sm:col-span-6">
                        <label for="competences" class="block text-sm font-medium text-gray-700">
                            Compétences requises <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="competences" name="competences" rows="5" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('competences') border-red-500 @enderror"
                                placeholder="Listez les compétences et qualifications requises...">{{ old('competences', isset($offre) ? $offre->competences : '') }}</textarea>
                        </div>
                        @error('competences')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Énumérez les compétences, l'expérience et les qualifications requises
                        </p>
                    </div>

                    <!-- Salaire -->
                    <div class="sm:col-span-3">
                        <label for="salaire" class="block text-sm font-medium text-gray-700">
                            Salaire <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="number" id="salaire" name="salaire" value="{{ old('salaire', isset($offre) ? $offre->salaire : '') }}" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('salaire') border-red-500 @enderror"
                                placeholder="ex: 35000">
                        </div>
                        @error('salaire')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="sm:col-span-6">
                        <label for="tags" class="block text-sm font-medium text-gray-700">
                            Tags <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="tags" name="tags[]" multiple required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('tags') border-red-500 @enderror">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ (isset($offre) && $offre->tags->contains($tag->id)) || old('tags') && in_array($tag->id, old('tags')) ? 'selected' : '' }}>
                                        {{ $tag->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Ajoutez des tags pertinents pour votre offre
                        </p>
                    </div>

                    <!-- Statut -->
                    <div class="sm:col-span-3">
                        <label for="statut" class="block text-sm font-medium text-gray-700">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="statut" name="statut" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('statut') border-red-500 @enderror">
                                <option value="ouverte" {{ old('statut', isset($offre) ? $offre->statut : 'ouverte') == 'ouverte' ? 'selected' : '' }}>Ouverte</option>
                                <option value="fermée" {{ old('statut', isset($offre) ? $offre->statut : 'ouverte') == 'fermée' ? 'selected' : '' }}>Fermée</option>
                            </select>
                        </div>
                        @error('statut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form actions -->
                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ isset($offre) ? route('recruteur.showAnnonce', $offre->id) : route('recruteur.offres') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isset($offre) ? 'Mettre à jour l\'offre' : 'Publier l\'offre' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Error notification -->
@if(session('error'))
<div class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Erreur</p>
                    <p class="mt-1 text-sm text-gray-500">{{ session('error') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button type="button" class="inline-flex text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@endsection