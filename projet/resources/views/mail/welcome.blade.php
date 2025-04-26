@extends('layouts.mail')

@section('content')
    <h1>Bienvenue sur TalentMatcher</h1>
    
    <p>Bonjour {{ $user->name }},</p>
    
    <p>Nous sommes ravis de vous accueillir sur notre plateforme de recrutement. TalentMatcher est là pour vous aider à trouver votre prochain emploi ou à recruter les meilleurs talents.</p>
    
    <p>Votre compte a été créé avec succès. Vous pouvez maintenant :</p>
    
    <ul>
        <li>Si vous êtes candidat : Créer votre profil et postuler aux offres d'emploi</li>
        <li>Si vous êtes recruteur : Publier vos offres d'emploi et gérer vos candidatures</li>
    </ul>
    
    <p>Pour commencer à utiliser votre compte, veuillez vous connecter à l'adresse suivante :</p>
    
    <p><a href="{{ url('/') }}" class="btn-primary">Se connecter à TalentMatcher</a></p>
    
    <p>Si vous avez des questions, n'hésitez pas à nous contacter à l'adresse : contact@talentmatcher.com</p>
    
    <p>Bonne chance dans votre recherche !</p>
    
    <p>L'équipe TalentMatcher</p>
@endsection