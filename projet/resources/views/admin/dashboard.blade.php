@extends('layouts.nav')

@section('title', 'Tableau de bord administrateur')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
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
            <canvas id="usersChart" class="w-full h-64"></canvas>
        </div>

        <!-- Statistiques des catégories -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des catégories</h3>
            <canvas id="categoriesChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Données transmises depuis le contrôleur Laravel
            // $userStats est un tableau associatif avec les rôles comme clés et les comptes comme valeurs 
            const userStatsLabels = @json(array_keys( $progression['users']['stats'] ));
            const userStatsData = @json(array_values($progression['users']['stats'] ));
            const categoryStatsLabels = @json(array_keys($progression['categories']['stats']));
            const categoryStatsData = @json(array_Values($progression['categories']['stats']));
            
            // Graphique des utilisateurs par rôle
            const ctxUsers = document.getElementById('usersChart').getContext('2d');
            new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: userStatsLabels,
                    datasets: [{
                        label: 'Nombre d\'utilisateurs',
                        data: userStatsData,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
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

            // Graphique des annonces par catégorie
            const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
            new Chart(ctxCategories, {
                type: 'bar', 
                data: {
                    labels: categoryStatsLabels, 
                    datasets: [{
                        label: 'Nombre d\'annonces',
                        data: categoryStatsData, 
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>

@endsection