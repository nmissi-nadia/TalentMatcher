@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Statistiques -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                    <div class="text-gray-500">Offres totales</div>
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
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="font-medium">Liste des offres</h2>
            <a href="{{ route('admin.annonce.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Offre
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Titre de l'offre</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date de publication</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Candidatures</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($annonces as $annonce)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-medium">{{ $annonce->titre }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $annonce->recruteur->name ?? 'Non spécifié' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $annonce->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $annonce->candidatures->count() }}</td>
                        <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $annonce->statut === 'ouverte' 
                                ? 'bg-green-100 text-green-800' 
                                : ($annonce->statut === 'fermee' 
                                    ? 'bg-yellow-100 text-yellow-800' 
                                    : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($annonce->statut) }}
                        </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('annonce.show', $annonce->id) }}" class="text-blue-600 hover:text-blue-800" title="Voir l'offre">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('annonce.edit', $annonce->id) }}" class="text-gray-600 hover:text-gray-800" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('annonce.delete', $annonce->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
               
            </div>
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