@extends('layouts.nav')
@section('title', 'Modération des Signalements')
@section('content')

<div class="container mx-auto px-4 py-8">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-flag text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Signalements Total</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-hourglass-half text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">En Attente</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['en_attente'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Résolus</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['resolus'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Rejetés</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['rejetes'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des signalements -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="font-medium">Liste des signalements</h2>
            <div class="flex items-center space-x-4">
                <select name="status" id="status" class="px-4 py-2 border rounded-lg">
                    <option value="">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="resolved">Résolus</option>
                    <option value="rejected">Rejetés</option>
                </select>
                <input type="text" placeholder="Rechercher..." class="px-4 py-2 border rounded-lg">
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Motif</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($signalements as $signalement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                <img src="{{ asset('storage/' . $signalement->utilisateur->photo) }}" 
                                     alt="{{ $signalement->utilisateur->name }}" 
                                     class="h-full w-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $signalement->utilisateur->name }}</p>
                                <p class="text-xs text-gray-500">{{ $signalement->utilisateur->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ ucfirst($signalement->type) }}</td>
                    <td class="px-6 py-4">{{ $signalement->motif }}</td>
                    <td class="px-6 py-4">{{ $signalement->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ 
                            $signalement->statut === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            ($signalement->statut === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($signalement->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button 
                            onclick="showTreatmentModal({{ $signalement->id }})"
                            class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            {{ $signalements->links() }}
        </div>
    </div>
</div>

<!-- Modal de traitement -->
<div id="treatmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-xl font-semibold mb-4">Traiter le signalement</h3>
        <form action="{{ route('admin.signalement.traiter', ['id' => 'signalementId']) }}" method="POST">
            @csrf
            <input type="hidden" id="signalementId" name="signalement_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Statut</label>
                <select name="statut" class="w-full px-3 py-2 border rounded-lg">
                    <option value="resolved">Résolus</option>
                    <option value="rejected">Rejetés</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Description du traitement</label>
                <textarea name="description" rows="4" 
                          class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeTreatmentModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Traiter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showTreatmentModal(signalementId) {
        
        document.getElementById('signalementId').value = signalementId;
        document.getElementById('treatmentModal').classList.remove('hidden');
    }

    function closeTreatmentModal() {
        document.getElementById('treatmentModal').classList.add('hidden');
    }

    document.getElementById('status').addEventListener('change', function(e) {
        window.location.href = `?status=${e.target.value}`;
    });

    document.querySelector('input[placeholder="Rechercher..."]').addEventListener('input', function(e) {
        window.location.href = `?search=${e.target.value}`;
    });
</script>
@endsection