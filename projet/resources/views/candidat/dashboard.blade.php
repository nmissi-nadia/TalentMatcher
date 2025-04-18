@extends('layouts.app')

@section('title', 'Tableau de Bord Candidat - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Stats Overview -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Applications Stats -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Candidatures</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $candidatures->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Jobs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Offres actives</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $activeJobs }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags Followed -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-tags text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tags suivis</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $user->tags->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Applications -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900">Candidatures récentes</h2>
                    <div class="mt-4">
                        @if($candidatures->count() > 0)
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($candidatures->take(5) as $candidature)
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div class="flex items-center h-5">
                                                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full bg-gray-100">
                                                            <i class="fas fa-circle text-gray-400"></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-500">{{ $candidature->annonce->title }}</p>
                                                            <p class="text-sm text-gray-500">{{ $candidature->annonce->company }}</p>
                                                            <p class="text-sm text-gray-500">{{ $candidature->annonce->location }}</p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $candidature->status_color }}-100 text-{{ $candidature->status_color }}-800">
                                                                {{ $candidature->status_label }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-4">Aucune candidature récente</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recommended Jobs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900">Offres recommandées</h2>
                    <div class="mt-4">
                        @if($recommendedJobs->count() > 0)
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($recommendedJobs->take(5) as $job)
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div class="flex items-center h-5">
                                                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full bg-gray-100">
                                                            <i class="fas fa-briefcase text-gray-400"></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-500">{{ $job->title }}</p>
                                                            <p class="text-sm text-gray-500">{{ $job->company }}</p>
                                                            <p class="text-sm text-gray-500">{{ $job->location }}</p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                            <a href="{{ route('annonces.show', $job->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                                Postuler
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-4">Aucune offre recommandée</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update status colors and labels
    @foreach($candidatures as $candidature)
        document.addEventListener('DOMContentLoaded', function() {
            let statusElement = document.getElementById('status-{{ $candidature->id }}');
            if (statusElement) {
                statusElement.style.backgroundColor = '{{ $candidature->status_color }}';
                statusElement.textContent = '{{ $candidature->status_label }}';
            }
        });
    @endforeach
</script>
@endpush