@extends('layouts.nav')
@section('title', isset($offre) ? 'Modifier une offre - TalentMatcher' : 'Créer une offre - TalentMatcher')
@section('content')

            <form action="{{ isset($offre) ? route('recruteur.updateAnnonce', $offre->id) : route('recruteur.annonces.store') }}" method="POST" class="space-y-8 px-6 py-8 sm:p-10">
                @csrf
                @if(isset($offre))
                    @method('PUT')
                @endif

                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Informations générales
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">
                            Titre du poste <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="titre" name="titre" 
                               value="{{ old('titre', isset($offre) ? $offre->titre : '') }}" required
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('titre') border-red-500 @enderror"
                               placeholder="ex: Développeur Full Stack JavaScript">
                        @error('titre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Un titre clair et concis qui décrit le poste (Max. 100 caractères)
                        </p>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select id="categorie_id" name="categorie_id" required
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('categorie_id') border-red-500 @enderror">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('categorie_id', isset($offre) ? $offre->categorie_id : '') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            Lieu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="location" name="location" 
                               value="{{ old('location', isset($offre) ? $offre->location : '') }}" required
                               class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('location') border-red-500 @enderror"
                               placeholder="ex: Paris, France">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description du poste <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('description') border-red-500 @enderror"
                                  placeholder="Décrivez les responsabilités et le contexte du poste...">{{ old('description', isset($offre) ? $offre->description : '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Décrivez les principales responsabilités et le contexte du poste
                        </p>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="competences" class="block text-sm font-medium text-gray-700 mb-1">
                            Compétences requises <span class="text-red-500">*</span>
                        </label>
                        <textarea id="competences" name="competences" rows="5" required
                                  class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('competences') border-red-500 @enderror"
                                  placeholder="Listez les compétences et qualifications requises...">{{ old('competences', isset($offre) ? $offre->competences : '') }}</textarea>
                        @error('competences')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Énumérez les compétences, l'expérience et les qualifications requises
                        </p>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="salaire" class="block text-sm font-medium text-gray-700 mb-1">
                            Salaire <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="salaire" name="salaire" 
                                   value="{{ old('salaire', isset($offre) ? $offre->salaire : '') }}" required
                                   class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('salaire') border-red-500 @enderror"
                                   placeholder="ex: 35000">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500">DH/mois</span>
                            </div>
                        </div>
                        @error('salaire')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="sm:col-span-6">
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">
                            Tags <span class="text-red-500">*</span>
                        </label>
                        <select id="tags" name="tags[]" multiple required
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('tags') border-red-500 @enderror">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ (isset($offre) && $offre->tags->contains($tag->id)) || old('tags') && in_array($tag->id, old('tags')) ? 'selected' : '' }}>
                                    {{ $tag->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Ajoutez des tags pertinents pour votre offre
                        </p>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <select id="statut" name="statut" required
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('statut') border-red-500 @enderror">
                            <option value="ouverte" {{ old('statut', isset($offre) ? $offre->statut : 'ouverte') == 'ouverte' ? 'selected' : '' }}>Ouverte</option>
                            <option value="fermée" {{ old('statut', isset($offre) ? $offre->statut : 'ouverte') == 'fermée' ? 'selected' : '' }}>Fermée</option>
                        </select>
                        @error('statut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 mt-8">
                    <div class="flex flex-col-reverse sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ isset($offre) ? route('recruteur.showAnnonce', $offre->id) : route('recruteur.offres') }}" 
                           class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            {{ isset($offre) ? 'Mettre à jour l\'offre' : 'Publier l\'offre' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    

@if(session('error'))
<div class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <div class="max-w-sm w-full bg-white shadow-lg rounded-xl pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
        <div class="p-5">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Erreur</p>
                    <p class="mt-1 text-sm text-gray-500">{{ session('error') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button type="button" 
                            class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" 
                            onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
@endsection