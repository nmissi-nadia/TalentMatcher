@extends('layouts.nav')

@section('title', 'Profil du Candidat - ' . $candidat->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex items-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mr-6">
                    <i class="fas fa-user text-6xl text-gray-400"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $candidat->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $candidat->email }}</p>
                    <p class="text-gray-600 mt-1">{{ $candidat->telephone }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations de base -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations de base</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-gray-500">Adresse</div>
                    <div class="text-gray-900">{{ $candidat->adresse }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Date de naissance</div>
                    <div class="text-gray-900">{{ $candidat->date_naissance }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Ville</div>
                    <div class="text-gray-900">{{ $candidat->ville }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Pays</div>
                    <div class="text-gray-900">{{ $candidat->pays }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CV -->
    @if($candidat->cv)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">CV</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-700">{{ $candidat->cv }}</p>
                </div>
                <div>
                    <a href="{{ asset('storage/cv/' . $candidat->cv) }}" 
                       class="text-blue-600 hover:text-blue-800"
                       target="_blank">
                        <i class="fas fa-download mr-2"></i>Télécharger le CV
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection