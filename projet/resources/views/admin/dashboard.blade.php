@extends('layouts.nav')

@section('title', 'Tableau de bord administrateur')

@section('content')
    <!-- Dashboard Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Statistiques des utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Utilisateurs</h3>
                    <p class="text-sm text-gray-600">Total des utilisateurs actifs</p>
                </div>
                <div class="text-3xl text-[#ea530c]">{{ $progression['users']['total'] }}</div>
            </div>
        </div>

        <!-- Statistiques des offres -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Offres</h3>
                    <p class="text-sm text-gray-600">Offres actives</p>
                </div>
                <div class="text-3xl text-[#ea530c]">{{ $progression['annonces']['active'] }}</div>
            </div>
        </div>

        <!-- Statistiques des candidatures -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Candidatures</h3>
                    <p class="text-sm text-gray-600">Total des candidatures</p>
                </div>
                <div class="text-3xl text-[#ea530c]">{{ $progression['candidatures']['total'] }}</div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribution des utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribution des utilisateurs</h3>
            <canvas id="userDistributionChart" class="w-full h-64"></canvas>
        </div>

        <!-- Statistiques des secteurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des secteurs</h3>
            <canvas id="activeSectorsChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Script pour les graphiques -->
    @push('scripts')
    <script>
        // Configuration des graphiques
        const userDistributionChart = new Chart(document.getElementById('userDistributionChart'), {
            type: 'pie',
            data: {
                labels: ['Utilisateurs actifs', 'Utilisateurs supprimés'],
                datasets: [{
                    data: [{{ $progression['users']['total'] }}, {{ $progression['users']['deleted'] }}],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' (' + Math.round((context.parsed / ({{ $progression['users']['total'] }} + {{ $progression['users']['deleted'] }}) * 100)) + '%)';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        const activeSectorsChart = new Chart(document.getElementById('activeSectorsChart'), {
            type: 'bar',
            data: {
                labels: ['Offres actives', 'Offres inactives'],
                datasets: [{
                    label: 'Nombre d\'offres',
                    data: [{{ $progression['annonces']['active'] }}, {{ $progression['annonces']['total'] - $progression['annonces']['active'] }}],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
@endsection