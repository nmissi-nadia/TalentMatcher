<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Tag;

class AdminController extends Controller
{
    

    public function index()
    {
        // Récupérer les statistiques
        // $totalUsers = User::count();
        // $activeAnnonces = Annonce::where('statut', 'active')->count();
        // $newCandidates = User::where('type', 'candidat')->where('created_at', '>', now()->subDays(30))->count();
        // $totalTags = Tag::count();

        return view('admin.dashboard');
    }
    public function utilisateurs()
    {
        $users = User::all();
        return view('admin.utilisateurs', compact('users'));
    }
    public function candidatures()
    {
        $candidatures = Candidature::all();
        return view('admin.candidatures', compact('candidatures'));
    }
    public function moderation()
    {
        return view('admin.moderation');
    }
    public function annonce()
    {
        return view('admin.annonces');
    }
}