@extends('layouts.nav')

@section('title', 'Gestion des Utilisateurs')

@section('content')
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4">
        <h1 class="text-xl font-bold">Gestion des Utilisateurs</h1>
        
        <div class="flex items-center space-x-4">
            <button class="relative">
                <i class="fas fa-bell text-gray-500"></i>
                <span class="absolute top-0 right-0 h-2 w-2 bg-primary rounded-full"></span>
            </button>
            
            <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden">
                <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar" class="h-full w-full object-cover">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-6">
        <!-- Tab Navigation -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button id="tab-all" class="px-6 py-4 border-b-2 border-primary text-primary font-medium">
                        Tous les utilisateurs
                    </button>
                    <button id="tab-recruiters" class="px-6 py-4 text-gray-500 hover:text-primary">
                        Recruteurs
                    </button>
                    <button id="tab-candidates" class="px-6 py-4 text-gray-500 hover:text-primary">
                        Candidats
                    </button>
                </nav>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Rechercher par nom" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Rechercher par email" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type d'utilisateur</label>
                    <div class="relative">
                        <select class="w-full border border-gray-300 rounded-md py-2 px-3 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                            <option>Tous les types</option>
                            <option>Recruteur</option>
                            <option>Candidat</option>
                            <option>Administrateur</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <div class="relative">
                        <select class="w-full border border-gray-300 rounded-md py-2 px-3 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                            <option>Tous les statuts</option>
                            <option>Actif</option>
                            <option>Inactif</option>
                            <option>En attente</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <button class="bg-primary hover:bg-[#d44a0b] text-white px-4 py-2 rounded-md transition">
                    <i class="fas fa-search mr-2"></i>Rechercher
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h2 class="font-medium">Liste des utilisateurs</h2>
                <button class="bg-primary hover:bg-[#d44a0b] text-white px-4 py-2 rounded-md transition">
                    <i class="fas fa-plus mr-2"></i>Ajouter un utilisateur
                </button>
            </div>
        
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                    <img src="{{ asset('storage/images/' . $user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full {{ $user->role === 'recruteur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.user.show', $user->id) }}" class="text-primary hover:text-[#d44a0b]">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
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
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
    Affichage de {{ $users->first() ? $users->first()->id : 0 }} à {{ $users->last() ? $users->last()->id : 0 }} sur {{ $users->count() }} utilisateurs
</div>
                <div class="flex justify-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    // Tab Navigation
    document.addEventListener('DOMContentLoaded', function() {
        const tabAll = document.getElementById('tab-all');
        const tabRecruiters = document.getElementById('tab-recruiters');
        const tabCandidates = document.getElementById('tab-candidates');
        
        const activateTab = (activeTab, inactiveTabs) => {
            activeTab.classList.add('border-b-2', 'border-primary', 'text-primary');
            activeTab.classList.remove('text-gray-500');
            
            inactiveTabs.forEach(tab => {
                tab.classList.remove('border-b-2', 'border-primary', 'text-primary');
                tab.classList.add('text-gray-500');
            });
        };
        
        tabAll.addEventListener('click', function() {
            activateTab(tabAll, [tabRecruiters, tabCandidates]);
            // Ici vous pourriez ajouter du code pour filtrer les données
        });
        
        tabRecruiters.addEventListener('click', function() {
            activateTab(tabRecruiters, [tabAll, tabCandidates]);
            // Ici vous pourriez ajouter du code pour filtrer les données
        });
        
        tabCandidates.addEventListener('click', function() {
            activateTab(tabCandidates, [tabAll, tabRecruiters]);
            // Ici vous pourriez ajouter du code pour filtrer les données
        });
    });
</script>
@endpush