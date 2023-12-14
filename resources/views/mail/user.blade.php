<x-mail::message>
# Confirmation de réservation

Bonjour {{ $user_name }},

Nous sommes heureux de confirmer que votre réservation avec **{{ $teacher_name }}** a été effectuée avec succès.

# Détails de Votre réservation
- **Date :** {{ $date }}
- **Montant payé :** {{ $price / 100 }} €
- **Professeur :** {{ $teacher_name }}
- **Spécialité à développer :** {{ $speciality }}

# Lien Google Meet pour votre Cours
**<a href="{{ $link_google_meet }}">Cliquer ici pour rejoindre le Google Meet à la date de la réservation</a>**

Nous vous encourageons à préparer toutes les questions ou les sujets que vous souhaitez aborder pendant votre session.

# Besoin d'Aide ?
Pour toute question ou en cas de modification nécessaire, n'hésitez pas à nous contacter à {{ config('mail.from.address') }}.

Nous vous souhaitons une expérience d'apprentissage enrichissante et agréable.

Cordialement,
{{ config('app.name') }}
</x-mail::message>
