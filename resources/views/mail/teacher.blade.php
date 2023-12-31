<x-mail::message>
# Bonjour {{ $teacherName }},

Nous sommes ravis de vous informer que vous avez reçu une nouvelle réservation de la part de **{{ $userName }}  ({{ $userEmail }})**.

# Détails de la réservation
- **Date :** {{ $date }}
- **Spécialité :** {{ $speciality }}

# Lien
**<a href="{{ $meetingLink }}">Cliquer ici pour rejoindre l'appel vidéo à la date de la réservation</a>**

Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter à {{ config('mail.from.address') }}.

Merci pour votre engagement.

Cordialement,
{{ config('app.name') }}
</x-mail::message>
