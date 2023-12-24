<x-mail::message>
# Bonjour {{ $teacher_name }},

Nous sommes ravis de vous informer que vous avez reçu une nouvelle réservation de la part de **{{ $user_name }}  ({{ $user_email }})**.

# Détails de la réservation
- **Date :** {{ $date }}
- **Montant payé :** {{ $price / 100 }} €
- **Spécialité à développer :** {{ $speciality }}


# Lien Google Meet
**<a href="{{ $link_google_meet }}">Cliquer ici pour rejoindre le Google Meet</a>**

Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter à {{ config('mail.from.address') }}.

Merci pour votre engagement.

Cordialement,
{{ config('app.name') }}
</x-mail::message>
