@extends('layouts.nav')

@section('title', 'Tableau de Bord Candidat')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Stats Overview -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Applications Stats -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Candidatures</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $candidatures->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active offres -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Offres actives</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $activeoffres }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
        
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Candidatures récentes</h2>
                        @if($candidatures->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($candidatures->take(5) as $candidature)
                                    <li class="py-4 flex justify-between items-center">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $candidature->annonce->titre }}</h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $candidature->annonce->recruteur->name }} • {{ $candidature->annonce->location }}
                                            </p>
                                        </div>
                                        <span class="px-4 py-1 text-xs font-medium rounded-full bg-{{ $candidature->status_color }}-100 text-{{ $candidature->status_color }}-800">
                                            {{ $candidature->statut }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucune candidature récente</p>
                        @endif
                    </div>
                </div>
            

          
        </div>
    </div>
</div>
@endsection