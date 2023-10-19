<button id="checkout-button"
        data-stripe-key="{{ config('stripe.key') }}"
        data-session-id="{{ $checkout_session_id }}">
    Payer
</button>

<script src="https://js.stripe.com/v3/"></script>
<script src="{{asset('js/stripe/stripe.js')}}"></script>
