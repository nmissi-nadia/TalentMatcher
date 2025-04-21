<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Tag;

use Illuminate\Support\Facades\DB;

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
        
        // Calculer les pourcentages de progression
        $progression = [
            'users' => [
                'total' => $totalUsers,
                'deleted' => $deletedUser,
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
            'progression' => $progression
        ]);
    }
    public function utilisateurs()
    {
        $users = User::orderBy('created_at', 'desc')->get();
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
    public function annonces()
    {
        $annonces = Annonce::with(['recruteur', 'tags'])
        ->orderBy('created_at', 'desc')
        ->get();

    $stats = [
        'total' => $annonces->count(),
        'actives' => $annonces->where('statut', 'ouverte')->count(),
        'expirees' => $annonces->where('statut', 'fermee')->count()
    ];

    return view('admin.annoces', compact('annonces', 'stats'));
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
    
    public function restaurerUtilisateur($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.supprimes')->with('success', 'Utilisateur restauré avec succès');
    }
    
    public function supprimerDefinitivement($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.supprimes')->with('success', 'Utilisateur supprimé définitivement');
    }
}