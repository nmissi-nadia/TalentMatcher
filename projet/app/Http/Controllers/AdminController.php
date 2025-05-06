<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Tag;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques
        $totalUsers = User::whereNull('deleted_at')->count();
        $deletedUser = User::onlyTrashed()->count();
        $activeAnnonces = Annonce::where('statut', 'ouverte')->count();
        $newCandidates = User::where('role', 'candidat')
            ->where('created_at', '>', now()->subDays(30))
            ->whereNull('deleted_at')
            ->count();
        $totalCandidatures = Candidature::count();
        $totalTags = Tag::count();
        $deletedUsers = User::onlyTrashed()->get();
        $candidats = User::where('role', 'candidat')->whereNull('deleted_at')->get();
        $candidatures = Candidature::with('candidat')->get();
        
        // Récupérer les offres les plus consultées
        $topoffres = Annonce::where('statut', 'ouverte')
            ->with(['recruteur', 'tags'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
        $userStats = User::select('role', \DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();
            $categoryStats = Categorie::withCount('annonces')->get()->pluck('annonces_count', 'nom')->toArray();
        // Calculer les pourcentages de progression
        $progression = [
            'users' => [
                'total' => $totalUsers,
                'deleted' => $deletedUser,
                'candidats' => $newCandidates,
                'stats' => $userStats,
                'percentage' => ($totalUsers + $deletedUser) > 0 ? round(($totalUsers / ($totalUsers + $deletedUser)) * 100) : 0
            ],
            'annonces' => [
                'active' => $activeAnnonces,
                'total' => Annonce::count(),
                'percentage' => ($activeAnnonces + Annonce::count()) > 0 ? round(($activeAnnonces / (Annonce::count())) * 100) : 0
            ],
            'candidats' => [
                'new' => $newCandidates,
                'total' => User::where('role', 'candidat')->whereNull('deleted_at')->count(),
                'percentage' => ($newCandidates + User::where('role', 'candidat')->whereNull('deleted_at')->count()) > 0 ? round(($newCandidates / (User::where('role', 'candidat')->whereNull('deleted_at')->count())) * 100) : 0
            ],
            'candidatures' => [
                'total' => $totalCandidatures,
                'percentage' => ($totalCandidatures + $totalCandidatures) > 0 ? round(($totalCandidatures / ($totalCandidatures + $totalCandidatures)) * 100) : 0
            ],
            'categories' => [
                'stats' => $categoryStats
            ]
        ];

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'deletedUser' => $deletedUser,
            'activeAnnonces' => $activeAnnonces,
            'newCandidates' => $newCandidates,
            'totalCandidatures' => $totalCandidatures,
            'totalTags' => $totalTags,
            'deletedUsers' => $deletedUsers,
            'topoffres' => $topoffres,
            'progression' => $progression,
            'userStats' => $userStats,
            'categoryStats' => $categoryStats
        ]);
    }
    // gestion des utilisateurs
    public function utilisateurs(Request $request)
    {
        $query = User::query();
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->role) {
            $query->where('role', $request->role);
        }
        $users = $query->paginate(5);

        return view('admin.utilisateurs', compact('users'));
    }
    public function candidatures()
    {
        $candidatures = Candidature::with(['candidat', 'annonce'])->orderBy('created_at', 'desc')->get();
        return view('admin.candidature', compact('candidatures'));
    }
    public function moderation()
    {
        $signalements = DB::table('signalements')
            ->join('users', 'signalements.user_id', '=', 'users.id')
            ->select('signalements.*', 'users.name as user_name')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.moderation', compact('signalements'));
    }
    

    public function annoncesActives()
    {
        $annonces = Annonce::with(['recruteur', 'tags'])
            ->where('statut', 'ouverte')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.annonces', compact('annonces'));
    }

    public function annoncesExpirees()
    {
        $annonces = Annonce::with(['recruteur', 'tags'])
            ->where('statut', 'fermee')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.annonces', compact('annonces'));
    }
    public function annonce($id)
    {
        $annonce = Annonce::with(['recruteur', 'tags'])->findOrFail($id);
        $candidatures = Candidature::where('annonce_id', $id)->with('candidat')->get();
        
        return view('admin.annonce', compact('annonce', 'candidatures'));
    }
    public function utilisateursSupprimes()
    {
        $users = User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        return view('admin.utilisateurs_supprimes', compact('users'));
    }
   
    
    public function supprimerDefinitivement($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.supprimes')->with('message', 'Utilisateur supprimé définitivement');
    }
    // partie pour la gestion des gatégories et des tags
    public function gestionTags_categorie()
    {
        $categories = Categorie::paginate(8);
        $tags = Tag::paginate(8);
        return view('Tags_Catégories.index', compact('categories', 'tags'));
    }
    // bannissement des utilisateurs
    public function banUser(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->bannir();
    return redirect()->back()->with('message', 'Utilisateur banni avec succès');
}

    // desbannissement des utilisateurs
    public function unbanUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->debannir();
        return redirect()->back()->with('message', 'Utilisateur débanni avec succès');
    }
    public function downloadStatsPDF()
    {
        // Récupérer les statistiques
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'actif')->count(),
            'total_announces' => Annonce::count(),
            'active_announces' => Annonce::where('statut', 'ouverte')->count(),
            'total_applications' => Candidature::count(),
            'new_users_last_month' => User::where('created_at', '>=', Carbon::now()->subMonth())->count(),
            'new_announces_last_month' => Annonce::where('created_at', '>=', Carbon::now()->subMonth())->count(),
            'top_categories' => Categorie::withCount('annonces')->orderBy('annonces_count', 'desc')->take(5)->get(),
            'top_competences' => Tag::withCount('annonces')->orderBy('annonces_count', 'desc')->take(5)->get(),
        ];

        // Créer le PDF
        $pdf = Pdf::loadView('admin.stats-pdf', compact('stats'));

        // Télécharger le PDF
        return $pdf->download('stats-platforme-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}