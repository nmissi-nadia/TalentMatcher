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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($annonces as $annonce)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-100 group">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-4 flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center shadow-inner">
                                <span class="text-indigo-700 font-bold text-lg">
                                    {{ substr($annonce->recruteur->name ?? '?', 0, 1) }}
                                </span>
                            </div>
                            
                            <div>
                                <h2 class="text-xl font-bold text-white truncate" title="{{ $annonce->titre }}">
                                    {{ $annonce->titre }}
                                </h2>
                                <p class="text-blue-100 text-sm flex items-center">
                                    <i class="fas fa-user-tie mr-1"></i>
                                    {{ $annonce->recruteur->name ?? 'Équipe de recrutement' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div class="bg-blue-50 rounded-lg p-3 mb-4 border border-blue-100">
                                <p class="text-sm text-gray-700 italic">
                                    "{{ $annonce->description_courte ?? 'Nous recherchons un talent motivé pour rejoindre notre équipe dynamique !' }}"
                                </p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="text-blue-500 mt-0.5 mr-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium">Localisation</p>
                                        <p class="text-gray-800">{{ $annonce->lieu ?? 'Flexible/Télétravail' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="text-green-500 mt-0.5 mr-3">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium">Type de contrat</p>
                                        <p class="text-gray-800">{{ $annonce->type_contrat ?? 'CDI' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="far fa-clock mr-1.5"></i>
                                        {{ $annonce->created_at->diffForHumans() }}
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <i class="fas fa-heart text-red-400 mr-1"></i>
                                        <span class="text-sm text-gray-600">
                                            {{ $annonce->candidatures->count() }} {{ Str::plural('candidat', $annonce->candidatures->count()) }} intéressé(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 pb-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $annonce->statut === 'ouverte' 
                                    ? 'bg-green-50 text-green-700 border border-green-200' 
                                    : ($annonce->statut === 'fermé' 
                                        ? 'bg-red-50 text-red-700 border border-red-200' 
                                        : 'bg-yellow-50 text-yellow-700 border border-yellow-200') }}">
                                @if($annonce->statut === 'ouverte')
                                    👍 <span class="ml-1.5">Recrutement actif</span>
                                @elseif($annonce->statut === 'fermé')
                                    ❌ <span class="ml-1.5">Poste pourvu</span>
                                @else
                                    ⏳ <span class="ml-1.5">En revue</span>
                                @endif
                            </span>

                            <div class="flex justify-end space-x-3 mt-4">
                                <a href="{{ route('admin.annonce.show', $annonce->id) }}" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200 group-hover:shadow-md hover:shadow-lg">
                                    <i class="far fa-eye mr-2"></i>
                                    <span>Découvrir l'offre</span>
                                    <i class="fas fa-chevron-right ml-1 text-xs opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1"></i>
                                </a>
                                
                                <form action="{{ route('admin.annonce.delete', $annonce->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-sm font-medium rounded-lg transition-all duration-200"
                                            onclick="return confirm('Cette action supprimera définitivement l\'offre. Continuer ?')">
                                        <i class="far fa-trash-alt mr-2"></i>
                                        <span>Archiver</span>
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