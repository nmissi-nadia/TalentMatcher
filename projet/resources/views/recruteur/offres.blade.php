@extends('layouts.app')

@section('title', 'Gestion des Offres - TalentMatcher')

@section('content')
<div class="container mx-auto px-20 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Mes Offres d'emploi</h1>
        <a href="{{ route('recruteur.annonces.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Créer une offre
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($annonces as $annonce)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $annonce->titre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                    $annonce->statut === 'active' ? 'bg-green-100 text-green-800' : 
                                    'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($annonce->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $annonce->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('recruteur.annonces.manage', $annonce->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Gérer</a>
                                <a href="{{ route('recruteur.annonces.edit', $annonce->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Modifier</a>
                                <form action="{{ route('recruteur.annonces.delete', $annonce->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection