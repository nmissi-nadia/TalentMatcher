@extends('layouts.nav')

@section('title', 'Gestion des Candidatures ')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Rechercher</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" 
                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" 
                            placeholder="Nom, email...">
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="status" name="status" 
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="accepte">Accepté</option>
                        <option value="refuse">Refusé</option>
                    </select>
                </div>

                <div>
                    <label for="job-title" class="block text-sm font-medium text-gray-700">Offre d'emploi</label>
                    <select id="job-title" name="job-title" 
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Toutes les offres</option>
                        @foreach($annonces as $annonce)
                            <option value="{{ $annonce->id }}">{{ $annonce->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Période</label>
                    <div class="mt-1 flex space-x-2">
                        <input type="date" id="start-date" 
                            class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <input type="date" id="end-date" 
                            class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900">Liste des candidatures</h2>
                <div class="flex items-center space-x-2">
                    <button id="clear-filters" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Réinitialiser
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Candidat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Offre d'emploi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date de candidature
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($candidatures as $candidature)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $candidature->candidat->profile_photo_url ?? asset('images/default-profile.png') }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $candidature->candidat->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $candidature->candidat->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $candidature->annonce->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $candidature->annonce->entreprise }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $candidature->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                        ($candidature->statut === 'en_attente' ? 'bg-blue-100 text-blue-800' : 
                                        ($candidature->statut === 'accepte' ? 'bg-green-100 text-green-800' : 
                                        ($candidature->statut === 'refuse' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ ucfirst($candidature->statut) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('recruteur.candidature.show', $candidature->id) }}" 
                                            class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                            Voir
                                        </a>
                                        <form action="{{ route('recruteur.candidature.status', $candidature->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                <i class="fas fa-edit"></i>
                                                Accepter
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Aucune candidature trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
            <div class="px-4 py-3 bg-gray-50">
                {{ $candidatures->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const jobTitleSelect = document.getElementById('job-title');
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const clearFiltersButton = document.getElementById('clear-filters');

    function applyFilters() {
        const params = new URLSearchParams(window.location.search);
        
        if (searchInput.value) {
            params.set('search', searchInput.value);
        }
        if (statusSelect.value) {
            params.set('status', statusSelect.value);
        }
        if (jobTitleSelect.value) {
            params.set('job', jobTitleSelect.value);
        }
        if (startDateInput.value) {
            params.set('start_date', startDateInput.value);
        }
        if (endDateInput.value) {
            params.set('end_date', endDateInput.value);
        }

        window.location.search = params.toString();
    }

    // Add event listeners
    searchInput.addEventListener('input', debounce(applyFilters, 500));
    statusSelect.addEventListener('change', applyFilters);
    jobTitleSelect.addEventListener('change', applyFilters);
    startDateInput.addEventListener('change', applyFilters);
    endDateInput.addEventListener('change', applyFilters);
    clearFiltersButton.addEventListener('click', () => {
        searchInput.value = '';
        statusSelect.value = '';
        jobTitleSelect.value = '';
        startDateInput.value = '';
        endDateInput.value = '';
        applyFilters();
    });
});

// Debounce function to prevent too many requests
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush
@endsection