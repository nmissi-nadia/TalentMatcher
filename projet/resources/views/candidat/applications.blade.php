@extends('layouts.nav')

@section('title', 'Mes Candidatures')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b border-gray-200">
        @error('test')
            <div class="text-red-500"> {{ $message }} </div>
        @enderror
            <p class="mt-1 text-sm text-gray-500">Suivez l'état de vos candidatures et gérez-les facilement.</p>
        </div>
    </div>

    <!-- Filtrage -->
    <div class="mt-6">
        <div class="bg-white shadow rounded-lg">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtrer par statut</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('candidat.candidatures') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 {{ request()->query('statut') ? '' : 'bg-blue-50 text-blue-600 border-blue-500' }}">
                        Tous
                    </a>
                    <a href="{{ route('candidat.candidatures', ['statut' => 'en_attente']) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 {{ request()->query('statut') === 'en_attente' ? 'bg-blue-50 text-blue-600 border-blue-500' : '' }}">
                        En attente
                    </a>
                    <a href="{{ route('candidat.candidatures', ['statut' => 'accepte']) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 {{ request()->query('statut') === 'accepte' ? 'bg-green-50 text-green-600 border-green-500' : '' }}">
                        Accepté
                    </a>
                    <a href="{{ route('candidat.candidatures', ['statut' => 'refuse']) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 {{ request()->query('statut') === 'refuse' ? 'bg-red-50 text-red-600 border-red-500' : '' }}">
                        Refusé
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des candidatures -->
    <div class="mt-6">
        @if($candidatures->isEmpty())
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <i class="fas fa-inbox fa-4x text-gray-300"></i>
                    <h3 class="text-lg font-medium text-gray-900">Aucune candidature</h3>
                    <p class="text-gray-500">Vous n'avez pas encore postulé à des offres.</p>
                    <a href="{{ route('candidat.offres') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Voir les offres
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($candidatures as $candidature)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($candidature->annonce->recruteur->logo)
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $candidature->annonce->recruteur->logo) }}" alt="{{ $candidature->annonce->recruteur->name }}">
                                                @else
                                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-building text-blue-600"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $candidature->annonce->titre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $candidature->annonce->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $candidature->annonce->recruteur->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $candidature->annonce->categorie->nom }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $candidature->created_at->format('d/m/Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $candidature->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            @php
                                                $statusStyles = [
                                                    'en attente' => 'bg-blue-100 text-blue-800',
                                                    'accepté' => 'bg-green-100 text-green-800',
                                                    'refusé' => 'bg-red-100 text-red-800'
                                                ];
                                                $style = isset($statusStyles[$candidature->statut]) 
                                                    ? $statusStyles[$candidature->statut] 
                                                    : 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="{{ $style }}">
                                                {{ ucfirst($candidature->statut) }}
                                            </span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                        <a href="{{ route('candidat.candidature.detail', $candidature->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                                Suivre Candidature
                                            </a>
                                            <a href="{{ route('candidat.offre.detail', $candidature->annonce->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                                Voir l'offre
                                            </a>
                                            @if($candidature->cv)
                                                <a href="{{ asset('storage/cvs' . $candidature->cv) }}" class="text-green-600 hover:text-green-900" download>
                                                    <i class="fas fa-download"></i>
                                                    Télécharger CV
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $candidatures->appends(request()->query())->links() }}
                </div>
            </div>
        @endif

        
    </div>
</div>

<!-- Scripts -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
@endsection