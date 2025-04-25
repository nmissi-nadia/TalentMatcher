<!-- page pour gérer les tags et les catégories -->
 @extends('layouts.nav')
 @section('title', 'Gestion des Tags et Catégories')
 @section('content')

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Tags et Catégories</h1>
        <p class="mt-2 text-gray-600">Organisez vos compétences et domaines d'expertise</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
       
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Catégories</h2>
                <button 
                    onclick="showAddCategoryModal()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Ajouter une catégorie
                </button>
            </div>

            <div class="space-y-4">
                @foreach($categories as $category)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->tags_count }} tags</p>
                    </div>
                    <div class="flex space-x-2">
                        <button 
                            onclick="editCategory({{ $category->id }})"
                            class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            onclick="deleteCategory({{ $category->id }})"
                            class="text-red-500 hover:text-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tags Section -->
     
    </div>

    <!-- Modals -->
    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-xl font-semibold mb-4">Ajouter une catégorie</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Couleur</label>
                    <select name="color" class="w-full px-3 py-2 border rounded-lg">
                        <option value="blue">Bleu</option>
                        <option value="green">Vert</option>
                        <option value="purple">Violet</option>
                        <option value="yellow">Jaune</option>
                        <option value="red">Rouge</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addCategoryModal')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

   
</div>

@section('scripts')
<script>
    function showAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    }

    

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
@endsection

 @endsection