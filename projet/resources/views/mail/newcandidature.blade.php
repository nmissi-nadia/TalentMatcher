@extends('layouts.mail')

@section('content')
    <h1>Nouvelle candidature pour votre offre</h1>

    <p>Bonjour {{ $offre->recruteur->name }},</p>

    <p>Vous avez reçu une nouvelle candidature pour votre offre : <strong>{{ $offre->titre }}</strong></p>

    <p>Les informations du candidat sont :</p>
    <ul>
        <li>Nom : {{ $candidat->name }}</li>
        <li>Email : {{ $candidat->email }}</li>
    </ul>

    <p>Vous pouvez consulter la candidature et gérer les candidatures de cette offre depuis votre espace recruteur.</p>

    <p><a href="{{ url('/recruteur/offres') }}" class="btn-primary">Gérer mes offres et candidatures</a></p>

    <p>Si vous avez des questions, n'hésitez pas à nous contacter à l'adresse : contact@talentmatcher.com</p>

    <p>L'équipe TalentMatcher</p>
@endsection