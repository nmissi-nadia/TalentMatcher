<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme de Recrutement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Section gauche - bannière bleue -->
        <div class="hidden md:flex md:w-1/2 bg-blue-600 text-white p-8 flex-col">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-4">Trouvez les meilleurs talents pour votre entreprise</h1>
                <p class="text-lg">Simplifiez votre processus de recrutement et connectez-vous avec des professionnels qualifiés.</p>
            </div>
            
            <div class="flex-grow">
                <img src="{{ asset('storage/images/img.png') }}" alt="Équipe professionnelle en réunion" class="w-full h-full object-cover rounded-lg">
            </div>
        </div>
        
        <!-- Section droite - formulaire de connexion -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="w-full max-w-md px-6">
                <h2 class="text-3xl font-bold mb-2 text-center">Bienvenue</h2>
                <p class="text-center text-gray-600 mb-8">Accédez à votre espace recruteur</p>
                
                <div class="mb-6 border-b border-gray-300">
                    <div class="flex">
                        <button id="tab-connexion" class="w-1/2 pb-4 text-center text-blue-600 border-b-2 border-blue-600 font-medium">Connexion</button>
                        <button id="tab-inscription" class="w-1/2 pb-4 text-center text-gray-500">Inscription</button>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('api.login') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm text-gray-700 mb-2">Email professionnel</label>
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
                    
                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200">
                        Se connecter
                    </button>
                </form>
                
                <div class="mt-6 text-center text-sm text-gray-600">
                    En vous inscrivant, vous acceptez nos 
                    <a href="#" class="text-blue-600 hover:underline">Conditions d'utilisation</a> et notre 
                    <a href="#" class="text-blue-600 hover:underline">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabConnexion = document.getElementById('tab-connexion');
            const tabInscription = document.getElementById('tab-inscription');
            
            tabConnexion.addEventListener('click', function() {
                tabConnexion.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabConnexion.classList.remove('text-gray-500');
                
                tabInscription.classList.add('text-gray-500');
                tabInscription.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                
                // Redirection ou logique pour afficher le formulaire de connexion
            });
            
            tabInscription.addEventListener('click', function() {
                tabInscription.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                tabInscription.classList.remove('text-gray-500');
                
                tabConnexion.classList.add('text-gray-500');
                tabConnexion.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                
                // Redirection vers la page d'inscription
                window.location.href = "{{ route('api.register') }}";
            });
        });
    </script>
</body>
</html>