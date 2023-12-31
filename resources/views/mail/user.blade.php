<x-mail::message>
# Confirmation de réservation

Bonjour {{ $userName }},

Nous sommes heureux de confirmer que votre réservation avec **{{ $teacherName }}** a été effectuée avec succès.

# Détails de Votre réservation
- **Date :** {{ $date }}
- **Montant payé :** {{ $price / 100 }} €
- **Professeur :** {{ $teacherName }}
- **Spécialité à développer :** {{ $speciality }}

# Lien de l'appel vidéo
**<a href="{{ $meetingLink }}">Cliquer ici pour rejoindre l'appel vidéo à la date de la réservation</a>**

Nous vous encourageons à préparer toutes les questions ou les sujets que vous souhaitez aborder pendant votre session.

# Besoin d'Aide ?
Pour toute question ou en cas de modification nécessaire, n'hésitez pas à nous contacter à {{ config('mail.from.address') }}.

Nous vous souhaitons une expérience d'apprentissage enrichissante et agréable.

Cordialement,
{{ config('app.name') }}
</x-mail::message>
