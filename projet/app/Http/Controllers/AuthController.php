<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Display login form
    public function loginForm()
    {
        return view('auth.login');
    }
    
    // Display register form
    public function registerForm()
    {
        return view('auth.register');
    }
    
    // Handle registration
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            "role" => "required|in:admin,candidat,recruteur"
        ]);
        
        // Create user
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role
        ]);
        
        return redirect()->route('login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }
    
    // Handle login
    public function login(Request $request)
    {
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // Attempt to log in
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            if (Auth::user()->role == 'candidat') {
                return redirect()->route('candidat.dashboard');
            } elseif (Auth::user()->role == 'recruteur') {
                return redirect()->route('recruteur.dashboard');
            } elseif (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Les informations fournies ne correspondent pas à nos enregistrements.',
        ])->withInput();
    }
    
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Déconnexion réussie');
    }
    
    // Display user profile
    public function profile()
    {
        $user = Auth::user();
        
        if ($user->role == 'candidat') {
            return view('candidat.profile', compact('user'));
        } elseif ($user->role == 'recruteur') {
            return view('recruteur.profile', compact('user'));
        } elseif ($user->role == 'admin') {
            return view('admin.profile', compact('user'));
        }
        
        return redirect()->route('login');
    }
    
    // Display password reset form
    public function resetPasswordForm()
    {
        return view('auth.passwords.reset');
    }
    
    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8|confirmed",
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Utilisateur non trouvé',
            ])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès');
    }
}