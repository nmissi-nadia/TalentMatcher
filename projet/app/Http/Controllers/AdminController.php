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
        $totalUsers = User::count();
        $activeAnnonces = Annonce::where('statut', 'ouverte')->count();
        $newCandidates = User::where('role', 'candidat')->where('created_at', '>', now()->subDays(30))->count();
        $totalCandidatures = Candidature::count();
        $totalTags = Tag::count();
        
        $statistics = [
            'totalUsers' => $totalUsers,
            'activeAnnonces' => $activeAnnonces,
            'newCandidates' => $newCandidates,
            'totalCandidatures' => $totalCandidatures,
            'totalTags' => $totalTags
        ];

        return view('admin.dashboard', compact('statistics'));
    }
    public function utilisateurs()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.utilisateurs', compact('users'));
    }
    public function candidatures()
    {
        $candidatures = Candidature::with(['candidat', 'annonce'])->orderBy('created_at', 'desc')->get();
        return view('admin.candidatures', compact('candidatures'));
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
        $annonces = Annonce::with(['recruteur', 'tags'])->orderBy('created_at', 'desc')->get();
        return view('admin.annonces', compact('annonces'));
    }
    
    public function annonce($id)
    {
        $annonce = Annonce::with(['recruteur', 'tags'])->findOrFail($id);
        $candidatures = Candidature::where('annonce_id', $id)->with('candidat')->get();
        
        return view('admin.annonce', compact('annonce', 'candidatures'));
    }
}