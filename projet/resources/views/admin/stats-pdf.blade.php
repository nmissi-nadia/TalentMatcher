<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistiques de la Plateforme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-section {
            margin-bottom: 40px;
        }
        .stats-box {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }
        .top-list {
            list-style-type: none;
            padding: 0;
        }
        .top-item {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-item-number {
            font-weight: bold;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Statistiques de la Plateforme</h1>
        <p>Date du rapport : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <div class="stats-section">
        <h2>Statistiques Générales</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Utilisateurs Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['active_users'] }}</div>
                <div class="stat-label">Utilisateurs Actifs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_announces'] }}</div>
                <div class="stat-label">Offres Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['active_announces'] }}</div>
                <div class="stat-label">Offres Actives</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_applications'] }}</div>
                <div class="stat-label">Candidatures Total</div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <h2>Activité Récemment</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['new_users_last_month'] }}</div>
                <div class="stat-label">Nouveaux Utilisateurs (30 jours)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['new_announces_last_month'] }}</div>
                <div class="stat-label">Nouvelles Offres (30 jours)</div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <h2>Catégories les plus populaires</h2>
        <div class="stats-box">
            <ul class="top-list">
                @foreach($stats['top_categories'] as $category)
                    <li class="top-item">
                        <span class="top-item-number">{{ $category->annonces_count }}</span>
                        <span>{{ $category->nom }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="stats-section">
        <h2>Compétences les plus demandées</h2>
        <div class="stats-box">
            <ul class="top-list">
                @foreach($stats['top_competences'] as $competence)
                    <li class="top-item">
                        <span class="top-item-number">{{ $competence->annonces_count }}</span>
                        <span>{{ $competence->nom }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>