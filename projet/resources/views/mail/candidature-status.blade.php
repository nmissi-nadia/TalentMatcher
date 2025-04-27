@extends('layouts.mail')

@section('content')
    <h1>Mise à jour du statut de votre candidature</h1>

    <p>Bonjour {{ $candidature->user->name }},</p>

    <p>Nous avons le plaisir de vous informer que votre candidature pour l'offre "{{ $candidature->annonce->titre }}" a été mise à jour.</p>

    <p>Nouveau statut : <strong>{{ ucfirst($statut) }}</strong></p>

    <p>Les détails de votre candidature sont :</p>
    <ul>
        <li>Offre : {{ $candidature->annonce->titre }}</li>
        <li>Entreprise : {{ $candidature->annonce->user->name }}</li>
        <li>Date de candidature : {{ $candidature->created_at->format('d/m/Y') }}</li>
    </ul>

    @if($statut === 'acceptée')
    <p>Félicitations ! Votre candidature a été acceptée. Vous serez contacté(e) prochainement par l'entreprise pour la suite du processus de recrutement.</p>
    @elseif($statut === 'refusée')
    <p>Malheureusement, votre candidature n'a pas été retenue pour cette offre. Nous vous souhaitons bonne chance pour vos futures candidatures.</p>
    @endif

    <p>Vous pouvez consulter l'état de vos candidatures depuis votre espace candidat.</p>

    <p><a href="{{ url('/candidat/candidatures') }}" class="btn-primary">Voir mes candidatures</a></p>

    <p>Si vous avez des questions, n'hésitez pas à nous contacter à l'adresse : contact@talentmatcher.com</p>

    <p>L'équipe TalentMatcher</p>
@endsection