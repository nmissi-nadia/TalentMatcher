<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signalement;

class ModerationController extends Controller
{
    public function index()
    {
        $signalements = Signalement::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Signalement::count(),
            'en_attente' => Signalement::where('statut', 'pending')->count(),
            'resolus' => Signalement::where('statut', 'resolved')->count(),
            'rejetes' => Signalement::where('statut', 'rejected')->count()
        ];

        return view('admin.moderation', compact('signalements', 'stats'));
    }
}
