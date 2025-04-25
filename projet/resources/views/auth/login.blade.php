<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme de Recrutement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Bannière gauche -->
         <!-- ajouter deux corner rounded -->
        <div class="hidden md:flex md:w-1/2 bg-[#4f46e5] text-white p-8 flex-col rounded-r-[30px]">
            <div class="mb-8">
                <h1 class="text-3xl text-[#ea580c] font-bold mb-4">Trouvez un emploi ou des talents de qualité</h1>
                <p class="text-lg">Que vous soyez candidat ou recruteur, connectez-vous facilement à la plateforme.</p>
            </div>
            
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('storage/images/img.png') }}" alt="Équipe professionnelle" class="w-full h-[500px] object-cover">
                
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/30 to-blue-500/30 mix-blend-overlay"></div>
                
                <div class="absolute inset-0 border-8 border-dashed border-[#ea580c]/40 rounded-lg"></div>
                
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-300/40 rounded-full blur-xl"></div>
                
                <div class="absolute top-0 left-0 w-full h-full bg-black/20 backdrop-filter backdrop-contrast-125"></div>
                
                <div class="absolute bottom-0 right-0 bg-white/10 backdrop-blur p-3 rounded-tl-lg">
                    <span class="text-white font-bold tracking-widest">ÉQUIPE</span>
                </div>
            </div>
        </div>

        <!-- Formulaire droit -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="w-full max-w-md px-6">
                <h2 class="text-3xl font-bold mb-2 text-center">Bienvenue</h2>
                <p class="text-center text-gray-600 mb-8">Connectez-vous ou créez un compte</p>

                <div class="mb-6 border-b border-gray-300">
                    <div class="flex">
                        <button id="tab-connexion" class="w-1/2 pb-4 text-center text-blue-600 border-b-2 border-blue-600 font-medium">Connexion</button>
                        <button id="tab-inscription" class="w-1/2 pb-4 text-center text-gray-500">Inscription</button>
                    </div>
                </div>

                <!-- Formulaire Connexion -->
                <div id="form-connexion" class="space-y-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm text-gray-700 mb-2">Adresse email</label>
                            <input id="email" type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm text-gray-700 mb-2">Mot de passe</label>
                            <input id="password" type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
                            </div>

                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button type="submit" class="w-full py-3 bg-[#ea580c] hover:bg-blue-700 text-white rounded-md transition duration-200">
                            Se connecter
                        </button>
                    </form>
                </div>

                <!-- Formulaire Inscription -->
                <div id="form-inscription" class="space-y-6 hidden">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm text-gray-700 mb-2">Nom complet ou entreprise</label>
                            <input id="name" type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm text-gray-700 mb-2">Adresse email</label>
                            <input id="email" type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="role" class="block text-sm text-gray-700 mb-2">Je suis un(e)</label>
                            <select id="role" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Sélectionnez un rôle --</option>
                                <option value="candidat">Candidat</option>
                                <option value="recruteur">Recruteur</option>
                            </select>
                        </div>

                        <div>
                            <label for="password" class="block text-sm text-gray-700 mb-2">Mot de passe</label>
                            <input id="password" type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" class="w-full py-3 bg-[#ea580c] hover:bg-blue-700 text-white rounded-md transition duration-200">
                            S'inscrire
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-center text-sm text-gray-600">
                    En vous inscrivant, vous acceptez nos 
                    <a href="#" class="text-blue-600 hover:underline">Conditions d'utilisation</a> et notre 
                    <a href="#" class="text-blue-600 hover:underline">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour le switch -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabConnexion = document.getElementById('tab-connexion');
            const tabInscription = document.getElementById('tab-inscription');
            const formConnexion = document.getElementById('form-connexion');
            const formInscription = document.getElementById('form-inscription');

            tabConnexion.addEventListener('click', function () {
                tabConnexion.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabConnexion.classList.remove('text-gray-500');

                tabInscription.classList.add('text-gray-500');
                tabInscription.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');

                formConnexion.classList.remove('hidden');
                formInscription.classList.add('hidden');
            });

            tabInscription.addEventListener('click', function () {
                tabInscription.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabInscription.classList.remove('text-gray-500');

                tabConnexion.classList.add('text-gray-500');
                tabConnexion.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');

                formConnexion.classList.add('hidden');
                formInscription.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>
