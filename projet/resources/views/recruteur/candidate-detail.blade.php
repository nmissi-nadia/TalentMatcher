@extends('layouts.nav')

@section('title', 'Détail de la Candidature - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl font-bold text-gray-900" id="candidate-name">
                    Candidature de <span>...</span>
                </h1>
                <p class="mt-1 text-sm text-gray-500" id="post-info">
                    Pour le poste : <span>...</span>
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ url('/recruteur/candidates') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux candidatures
                </a>
                <button id="change-status-btn" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    Changer le statut
                </button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-5 sm:px-0">
        <!-- Loading state -->
        <div id="loading-state" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
            <p class="text-gray-500">Chargement des informations...</p>
        </div>
        
        <!-- Content (hidden while loading) -->
        <div id="content-container" class="hidden">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <!-- Left column: Candidate information -->
                <div class="md:col-span-1">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informations du candidat</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0 h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500 text-3xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-medium text-gray-900" id="candidate-full-name">...</h2>
                                    <p class="text-sm text-gray-500" id="candidate-email">...</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                        <dd class="mt-1 text-sm text-gray-900" id="candidate-phone">...</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Localisation</dt>
                                        <dd class="mt-1 text-sm text-gray-900" id="candidate-location">...</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Expérience</dt>
                                        <dd class="mt-1 text-sm text-gray-900" id="candidate-experience">...</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Formation</dt>
                                        <dd class="mt-1 text-sm text-gray-900" id="candidate-education">...</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <dt class="text-sm font-medium text-gray-500">Compétences</dt>
                                <dd class="mt-2">
                                    <div class="flex flex-wrap gap-2" id="candidate-skills">
                                        <!-- Skills will be added here dynamically -->
                                    </div>
                                </dd>
                            </div>
                            
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-medium text-gray-500">Documents</h4>
                                <ul class="mt-2 divide-y divide-gray-200" id="candidate-documents">
                                    <!-- Documents will be added here dynamically -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Application details -->
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Statut de la candidature</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div id="application-status-badge" class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                    En attente
                                </div>
                                <span class="ml-2 text-sm text-gray-500" id="application-date">
                                    Candidature soumise le ...
                                </span>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-500">Progression</h4>
                                <div class="mt-2">
                                    <div class="relative">
                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                            <div id="progress-bar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500" style="width: 0%"></div>
                                        </div>
                                        <div class="mt-4 grid grid-cols-4 text-xs text-gray-500">
                                            <div class="text-center">
                                                <div id="step-1" class="w-6 h-6 mx-auto rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-check text-white"></i>
                                                </div>
                                                <p class="mt-1">Candidature</p>
                                            </div>
                                            <div class="text-center">
                                                <div id="step-2" class="w-6 h-6 mx-auto rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <p class="mt-1">Entretien</p>
                                            </div>
                                            <div class="text-center">
                                                <div id="step-3" class="w-6 h-6 mx-auto rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-code text-white"></i>
                                                </div>
                                                <p class="mt-1">Test technique</p>
                                            </div>
                                            <div class="text-center">
                                                <div id="step-4" class="w-6 h-6 mx-auto rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-flag text-white"></i>
                                                </div>
                                                <p class="mt-1">Décision</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Lettre de motivation</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose max-w-none text-gray-900" id="motivation-letter">
                                <!-- Motivation letter will be added here dynamically -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Notes et commentaires</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div id="notes-container" class="space-y-6">
                                <!-- Notes will be added here dynamically -->
                            </div>
                            
                            <form id="add-note-form" class="mt-6 border-t border-gray-200 pt-6">
                                <div>
                                    <label for="note-content" class="block text-sm font-medium text-gray-700">Ajouter une note</label>
                                    <div class="mt-1">
                                        <textarea id="note-content" name="note-content" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ajouter un commentaire ou une note sur cette candidature..."></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-plus mr-2"></i>
                                        Ajouter la note
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div id="status-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exchange-alt text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Changer le statut de la candidature
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="modal-candidate-name">
                                Candidature de ...
                            </p>
                            <div class="mt-4">
                                <label for="new-status" class="block text-sm font-medium text-gray-700">
                                    Nouveau statut
                                </label>
                                <select id="new-status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="en_attente">En attente</option>
                                    <option value="entretien">Entretien</option>
                                    <option value="test_technique">Test technique</option>
                                    <option value="acceptee">Acceptée</option>
                                    <option value="rejetee">Rejetée</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="status-note" class="block text-sm font-medium text-gray-700">
                                    Note (optionnelle)
                                </label>
                                <textarea id="status-note" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ajouter une note concernant ce changement de statut..."></textarea>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="notify-candidate" name="notify-candidate" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="notify-candidate" class="font-medium text-gray-700">Notifier le candidat</label>
                                        <p class="text-gray-500">Un email sera envoyé au candidat pour l'informer du changement de statut</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm-status-change" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer
                </button>
                <button type="button" id="cancel-status-change" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        try {
            // Get application ID from URL
            const urlParts = window.location.pathname.split('/');
            const applicationId = urlParts[urlParts.length - 1];
            
            // Load application data
            await loadApplicationData(applicationId);
            
            // Set up event listeners
            document.getElementById('change-status-btn').addEventListener('click', showStatusModal);
            document.getElementById('cancel-status-change').addEventListener('click', hideStatusModal);
            document.getElementById('modal-backdrop').addEventListener('click', hideStatusModal);
            document.getElementById('confirm-status-change').addEventListener('click', confirmStatusChange);
            document.getElementById('add-note-form').addEventListener('submit', handleAddNote);
        } catch (error) {
            console.error('Error initializing page:', error);
            window.showNotification('Erreur lors du chargement des données', 'error');
        }
    });
    
    // Global variables
    let applicationData = null;
    
    // Function to load application data
    async function loadApplicationData(applicationId) {
        try {
            // Show loading state
            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('content-container').classList.add('hidden');
            
            // Check if API client is available
            if (!window.apiClient || !window.candidatures) {
                console.error('API client not available');
                await simulateDataLoad(applicationId);
                return;
            }
            
            // Get application data from API
            applicationData = await window.candidatures.getById(applicationId);
            
            // Update UI with application data
            updateUI(applicationData);
            
            // Hide loading state, show content
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('content-container').classList.remove('hidden');
        } catch (error) {
            console.error('Error loading application data:', error);
            window.showNotification('Erreur lors du chargement des données de la candidature', 'error');
            await simulateDataLoad(applicationId);
        }
    }
    
    // Function to simulate data load (for demo purposes)
    async function simulateDataLoad(applicationId) {
        // Generate fake data
        applicationData = generateSampleData(applicationId);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Update UI with simulated data
        updateUI(applicationData);
        
        // Hide loading state, show content
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('content-container').classList.remove('hidden');
    }
    
    // Function to update UI with application data
    function updateUI(data) {
        // Update candidate info
        document.getElementById('candidate-name').innerHTML = `Candidature de <span class="text-blue-600">${data.candidat.name}</span>`;
        document.getElementById('post-info').innerHTML = `Pour le poste : <span class="font-medium">${data.annonce.titre}</span>`;
        document.getElementById('candidate-full-name').textContent = data.candidat.name;
        document.getElementById('candidate-email').textContent = data.candidat.email;
        document.getElementById('candidate-phone').textContent = data.candidat.phone || 'Non renseigné';
        document.getElementById('candidate-location').textContent = data.candidat.location || 'Non renseigné';
        document.getElementById('candidate-experience').textContent = data.candidat.experience || 'Non renseigné';
        document.getElementById('candidate-education').textContent = data.candidat.education || 'Non renseigné';
        
        // Update modal candidate name
        document.getElementById('modal-candidate-name').textContent = `Candidature de ${data.candidat.name}`;
        
        // Update application date
        const applicationDate = new Date(data.created_at);
        document.getElementById('application-date').textContent = `Candidature soumise le ${applicationDate.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        })}`;
        
        // Update skills
        const skillsContainer = document.getElementById('candidate-skills');
        skillsContainer.innerHTML = '';
        
        if (data.candidat.skills && data.candidat.skills.length > 0) {
            data.candidat.skills.forEach(skill => {
                const skillBadge = document.createElement('span');
                skillBadge.className = 'px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full';
                skillBadge.textContent = skill;
                skillsContainer.appendChild(skillBadge);
            });
        } else {
            const noSkills = document.createElement('p');
            noSkills.className = 'text-sm text-gray-500';
            noSkills.textContent = 'Aucune compétence renseignée';
            skillsContainer.appendChild(noSkills);
        }
        
        // Update documents
        const documentsContainer = document.getElementById('candidate-documents');
        documentsContainer.innerHTML = '';
        
        if (data.documents && data.documents.length > 0) {
            data.documents.forEach(doc => {
                const docItem = document.createElement('li');
                docItem.className = 'py-3 flex justify-between items-center';
                
                // Determine icon based on file type
                let fileIcon = 'file';
                if (doc.type === 'cv' || doc.name.toLowerCase().includes('cv')) {
                    fileIcon = 'file-alt';
                } else if (doc.type === 'letter' || doc.name.toLowerCase().includes('lettre')) {
                    fileIcon = 'file-contract';
                } else if (['pdf', 'docx', 'doc'].some(ext => doc.name.toLowerCase().endsWith(ext))) {
                    fileIcon = 'file-pdf';
                }
                
                docItem.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${fileIcon} text-gray-400 mr-3"></i>
                        <span class="text-sm text-gray-900">${doc.name}</span>
                    </div>
                    <a href="${doc.url}" download class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-download"></i>
                    </a>
                `;
                
                documentsContainer.appendChild(docItem);
            });
        } else {
            const noDocuments = document.createElement('li');
            noDocuments.className = 'py-3';
            noDocuments.textContent = 'Aucun document joint';
            documentsContainer.appendChild(noDocuments);
        }
        
        // Update status badge
        updateStatusBadge(data.statut);
        
        // Update progress steps
        updateProgressSteps(data.statut);
        
        // Update motivation letter
        const motivationLetter = document.getElementById('motivation-letter');
        if (data.lettre_motivation) {
            motivationLetter.innerHTML = `<p>${data.lettre_motivation.replace(/\n/g, '<br>')}</p>`;
        } else {
            motivationLetter.innerHTML = '<p class="text-gray-500">Aucune lettre de motivation fournie</p>';
        }
        
        // Update notes
        const notesContainer = document.getElementById('notes-container');
        notesContainer.innerHTML = '';
        
        if (data.notes && data.notes.length > 0) {
            data.notes.forEach(note => {
                const noteDate = new Date(note.created_at);
                const formattedDate = noteDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                const noteElement = document.createElement('div');
                noteElement.className = 'pb-5 border-b border-gray-200';
                noteElement.innerHTML = `
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-medium text-gray-900">${note.author || 'Recruteur'}</h4>
                        <p class="text-xs text-gray-500">${formattedDate}</p>
                    </div>
                    <div class="mt-1 text-sm text-gray-900">
                        <p>${note.content.replace(/\n/g, '<br>')}</p>
                    </div>
                `;
                
                notesContainer.appendChild(noteElement);
            });
        } else {
            const noNotes = document.createElement('div');
            noNotes.className = 'text-center py-4 text-gray-500';
            noNotes.textContent = 'Aucune note pour le moment';
            notesContainer.appendChild(noNotes);
        }
    }
    
    // Function to update status badge
    function updateStatusBadge(status) {
        const badge = document.getElementById('application-status-badge');
        
        // Clear existing classes
        badge.className = 'px-2 py-1 text-sm rounded-full';
        
        // Add new classes based on status
        switch(status) {
            case 'en_attente':
                badge.classList.add('bg-yellow-100', 'text-yellow-800');
                badge.textContent = 'En attente';
                break;
            case 'entretien':
                badge.classList.add('bg-blue-100', 'text-blue-800');
                badge.textContent = 'Entretien';
                break;
            case 'test_technique':
                badge.classList.add('bg-purple-100', 'text-purple-800');
                badge.textContent = 'Test technique';
                break;
            case 'acceptee':
                badge.classList.add('bg-green-100', 'text-green-800');
                badge.textContent = 'Acceptée';
                break;
            case 'rejetee':
                badge.classList.add('bg-red-100', 'text-red-800');
                badge.textContent = 'Rejetée';
                break;
            default:
                badge.classList.add('bg-gray-100', 'text-gray-800');
                badge.textContent = 'Inconnu';
        }
    }
    
    // Function to update progress steps
    function updateProgressSteps(status) {
        // Reset all steps
        for (let i = 1; i <= 4; i++) {
            const step = document.getElementById(`step-${i}`);
            step.className = 'w-6 h-6 mx-auto rounded-full flex items-center justify-center';
            step.classList.add('bg-gray-300');
        }
        
        const progressBar = document.getElementById('progress-bar');
        
        // Update steps based on status
        switch(status) {
            case 'en_attente':
                document.getElementById('step-1').classList.remove('bg-gray-300');
                document.getElementById('step-1').classList.add('bg-blue-500');
                progressBar.style.width = '25%';
                break;
            case 'entretien':
                document.getElementById('step-1').classList.remove('bg-gray-300');
                document.getElementById('step-1').classList.add('bg-green-500');
                document.getElementById('step-2').classList.remove('bg-gray-300');
                document.getElementById('step-2').classList.add('bg-blue-500');
                progressBar.style.width = '50%';
                break;
            case 'test_technique':
                document.getElementById('step-1').classList.remove('bg-gray-300');
                document.getElementById('step-1').classList.add('bg-green-500');
                document.getElementById('step-2').classList.remove('bg-gray-300');
                document.getElementById('step-2').classList.add('bg-green-500');
                document.getElementById('step-3').classList.remove('bg-gray-300');
                document.getElementById('step-3').classList.add('bg-blue-500');
                progressBar.style.width = '75%';
                break;
            case 'acceptee':
                document.getElementById('step-1').classList.remove('bg-gray-300');
                document.getElementById('step-1').classList.add('bg-green-500');
                document.getElementById('step-2').classList.remove('bg-gray-300');
                document.getElementById('step-2').classList.add('bg-green-500');
                document.getElementById('step-3').classList.remove('bg-gray-300');
                document.getElementById('step-3').classList.add('bg-green-500');
                document.getElementById('step-4').classList.remove('bg-gray-300');
                document.getElementById('step-4').classList.add('bg-green-500');
                progressBar.style.width = '100%';
                break;
            case 'rejetee':
                document.getElementById('step-1').classList.remove('bg-gray-300');
                document.getElementById('step-1').classList.add('bg-green-500');
                document.getElementById('step-2').classList.remove('bg-gray-300');
                document.getElementById('step-2').classList.add('bg-red-500');
                progressBar.style.width = '50%';
                break;
            default:
                progressBar.style.width = '0%';
        }
    }
    
    // Function to show status change modal
    function showStatusModal() {
        if (!applicationData) return;
        
        // Set current status in dropdown
        document.getElementById('new-status').value = applicationData.statut || 'en_attente';
        document.getElementById('status-note').value = '';
        document.getElementById('notify-candidate').checked = true;
        
        // Show modal
        const modal = document.getElementById('status-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    // Function to hide status change modal
    function hideStatusModal() {
        const modal = document.getElementById('status-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Function to confirm status change
    async function confirmStatusChange() {
        try {
            // Get new status and note
            const newStatus = document.getElementById('new-status').value;
            const note = document.getElementById('status-note').value.trim();
            const notifyCandidate = document.getElementById('notify-candidate').checked;
            
            // Check if status has changed
            if (newStatus === applicationData.statut && !note) {
                hideStatusModal();
                return;
            }
            
            // Check if API client is available
            if (!window.apiClient || !window.candidatures) {
                console.error('API client not available');
                simulateStatusChange(newStatus, note, notifyCandidate);
                return;
            }
            
            // Prepare data to update
            const updateData = {
                statut: newStatus
            };
            
            // Add note if provided
            if (note) {
                // In a real app, we would add the note to the application
                // For demo, we'll just update local data
                if (!applicationData.notes) {
                    applicationData.notes = [];
                }
                
                applicationData.notes.unshift({
                    content: note,
                    author: 'Recruteur',
                    created_at: new Date().toISOString()
                });
            }
            
            // Update application status in API
            await window.candidatures.update(applicationData.id, updateData);
            
            // Update local data
            applicationData.statut = newStatus;
            
            // Update UI
            updateUI(applicationData);
            
            // Show success notification
            window.showNotification('Statut mis à jour avec succès', 'success');
            
            // Show notification about email if checked
            if (notifyCandidate) {
                window.showNotification('Email de notification envoyé au candidat', 'info');
            }
        } catch (error) {
            console.error('Error updating application status:', error);
            window.showNotification('Erreur lors de la mise à jour du statut', 'error');
        } finally {
            hideStatusModal();
        }
    }
    
    // Function to simulate status change (for demo)
    function simulateStatusChange(newStatus, note, notifyCandidate) {
        // Update local data
        applicationData.statut = newStatus;
        
        // Add note if provided
        if (note) {
            if (!applicationData.notes) {
                applicationData.notes = [];
            }
            
            applicationData.notes.unshift({
                content: note,
                author: 'Recruteur',
                created_at: new Date().toISOString()
            });
        }
        
        // Update UI
        updateUI(applicationData);
        
        // Show success notification
        window.showNotification('Statut mis à jour avec succès', 'success');
        
        // Show notification about email if checked
        if (notifyCandidate) {
            window.showNotification('Email de notification envoyé au candidat', 'info');
        }
        
        // Hide modal
        hideStatusModal();
    }
    
    // Function to handle adding a note
    async function handleAddNote(event) {
        event.preventDefault();
        
        const noteContent = document.getElementById('note-content').value.trim();
        if (!noteContent) return;
        
        try {
            // Check if API client is available
            if (!window.apiClient || !window.candidatures) {
                console.error('API client not available');
                simulateAddNote(noteContent);
                return;
            }
            
            // In a real app, we would call an API endpoint to add a note
            // For demo, we'll just update local data
            if (!applicationData.notes) {
                applicationData.notes = [];
            }
            
            // Add note to local data
            applicationData.notes.unshift({
                content: noteContent,
                author: 'Recruteur',
                created_at: new Date().toISOString()
            });
            
            // Update UI
            updateUI(applicationData);
            
            // Clear input
            document.getElementById('note-content').value = '';
            
            // Show success notification
            window.showNotification('Note ajoutée avec succès', 'success');
        } catch (error) {
            console.error('Error adding note:', error);
            window.showNotification('Erreur lors de l\'ajout de la note', 'error');
        }
    }
    
    // Function to simulate adding a note (for demo)
    function simulateAddNote(noteContent) {
        // Update local data
        if (!applicationData.notes) {
            applicationData.notes = [];
        }
        
        // Add note to local data
        applicationData.notes.unshift({
            content: noteContent,
            author: 'Recruteur',
            created_at: new Date().toISOString()
        });
        
        // Update UI
        updateUI(applicationData);
        
        // Clear input
        document.getElementById('note-content').value = '';
        
        // Show success notification
        window.showNotification('Note ajoutée avec succès', 'success');
    }
    
    // Function to generate sample data for demo
    function generateSampleData(id) {
        const now = new Date();
        const createdAt = new Date(now.getTime() - 7 * 86400000); // 7 days ago
        
        return {
            id: id,
            annonce_id: 1,
            annonce: {
                id: 1,
                titre: 'Développeur Full Stack JavaScript',
                description: 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe.',
                statut: 'ouverte'
            },
            candidat: {
                id: 3,
                name: 'Thomas Dubois',
                email: 'thomas.dubois@example.com',
                phone: '+33 6 12 34 56 78',
                location: 'Paris, France',
                experience: '5 ans d\'expérience en développement web',
                education: 'Master en Informatique, Université de Paris',
                skills: ['JavaScript', 'React', 'Node.js', 'MongoDB', 'Express', 'Git', 'Docker']
            },
            statut: 'entretien',
            created_at: createdAt.toISOString(),
            lettre_motivation: `Madame, Monsieur,\n\nJe me permets de vous soumettre ma candidature pour le poste de Développeur Full Stack JavaScript que vous proposez actuellement.\n\nFort de 5 années d'expérience dans le développement web, j'ai eu l'opportunité de travailler sur des projets variés allant des applications mobiles aux plateformes e-commerce. Mon expertise technique couvre l'ensemble du stack avec une maîtrise approfondie de React, Node.js et des bases de données NoSQL comme MongoDB.\n\nLa mission et les valeurs de votre entreprise résonnent particulièrement avec ma vision du développement logiciel : créer des solutions innovantes qui répondent aux besoins réels des utilisateurs.\n\nJe serais ravi de pouvoir échanger avec vous pour vous présenter plus en détail mon parcours et ma motivation à rejoindre votre équipe.\n\nJe vous remercie pour l'attention portée à ma candidature et reste à votre disposition pour toute information complémentaire.\n\nCordialement,\nThomas Dubois`,
            documents: [
                {
                    name: 'CV_Thomas_Dubois.pdf',
                    type: 'cv',
                    url: '#'
                },
                {
                    name: 'Lettre_de_motivation.pdf',
                    type: 'letter',
                    url: '#'
                },
                {
                    name: 'Diplome_Master_Informatique.pdf',
                    type: 'diploma',
                    url: '#'
                }
            ],
            notes: [
                {
                    content: 'Candidat très prometteur. Le premier entretien s\'est très bien passé, il maîtrise les technologies requises et semble avoir une bonne méthodologie de travail.',
                    author: 'Émilie Martin',
                    created_at: new Date(now.getTime() - 3 * 86400000).toISOString() // 3 days ago
                },
                {
                    content: 'A prévu un test technique pour la semaine prochaine. Je lui ai envoyé les détails par email.',
                    author: 'Pierre Durand',
                    created_at: new Date(now.getTime() - 1 * 86400000).toISOString() // 1 day ago
                }
            ]
        };
    }
</script>
@endsection