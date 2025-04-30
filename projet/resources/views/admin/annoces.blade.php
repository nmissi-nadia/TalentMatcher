@extends('layouts.nav')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Statistiques -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                    <div class="text-gray-500">Offres totales</div>
                    <script>
                        console.log({{ $stats['total'] }});
                    </script>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['actives'] }}</div>
                    <div class="text-gray-500">Offres actives</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['expirees'] }}</div>
                    <div class="text-gray-500">Offres expirées</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.annonces') }}" 
                   class="px-4 py-4 text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 {{ request()->routeIs('admin.annonces') ? 'text-blue-600 border-blue-600' : '' }}">
                    Toutes
                </a>
                <a href="" 
                   class="px-4 py-4 text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 {{ request()->routeIs('admin.annonces.actives') ? 'text-green-600 border-green-600' : '' }}">
                    Actives
                </a>
                <a href="" 
                   class="px-4 py-4 text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 {{ request()->routeIs('annonces.expirees') ? 'text-yellow-600 border-yellow-600' : '' }}">
                    Expirées
                </a>
            </nav>
        </div>
    </div>

    <!-- Liste des offres -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden px-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="font-medium">Liste des offres</h2>
           
        </div>
        <div class="overflow-x-auto mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($annonces as $annonce)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-100">
                    <!-- Header avec gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-4">
                        <h2 class="text-xl font-bold text-white truncate" title="{{ $annonce->titre }}">
                            {{ $annonce->titre }}
                        </h2>
                    </div>
                    
                    <div class="p-5">
                        <p class="text-gray-700 flex items-center mb-3">
                            <i class="fas fa-building text-blue-500 mr-2"></i>
                            <span class="font-semibold mr-1">Entreprise:</span> 
                            {{ $annonce->recruteur->name ?? 'Non spécifié' }}
                        </p>

                        <div class="grid grid-cols-2 gap-3 mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                Publié le: {{ $annonce->created_at->format('d/m/Y') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users mr-2 text-green-500"></i>
                                {{ $annonce->candidatures->count() }} candidature(s)
                            </div>
                        </div>
                    </div>

                    <div class="px-5 pb-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mr-2
                            {{ $annonce->statut === 'ouverte' 
                                ? 'bg-green-100 text-green-800' 
                                : ($annonce->statut === 'fermé' 
                                    ? 'bg-red-100 text-red-800' 
                                    : 'bg-yellow-100 text-yellow-800') }}">
                            <i class="fas fa-circle text-xs mr-1.5"></i>
                            {{ ucfirst($annonce->statut) }}
                        </span>

                        <div class="flex justify-end space-x-2 mt-4">
                            <a href="{{ route('admin.annonce.show', $annonce->id) }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 transform hover:scale-105 shadow-sm">
                                <i class="fas fa-eye mr-2"></i>Voir
                            </a>
                            
                            <form action="{{ route('admin.annonce.delete', $annonce->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-[#ea530c] hover:bg-[#d44a0b] text-white text-sm font-medium rounded-lg transition duration-200 transform hover:scale-105 shadow-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                    <i class="fas fa-trash mr-2"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

                    <!-- Pagination -->
            <div class="px-6 py-4 bg-[#f5f5f5] border-t border-gray-200 rounded-b-xl">
                {{ $annonces->links() }}
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ajouter des effets de survol sur les boutons d'action
    document.querySelectorAll('.fa-eye, .fa-edit, .fa-trash').forEach(icon => {
        icon.addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.1)';
        });
        icon.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
        });
    });
</script>
@endpush