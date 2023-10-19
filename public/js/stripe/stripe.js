const checkoutButton = document.getElementById("checkout-button");
const stripeKey = checkoutButton.getAttribute('data-stripe-key');
const sessionId = checkoutButton.getAttribute('data-session-id');

const stripe = Stripe(stripeKey);

checkoutButton.addEventListener("click", function() {
    stripe.redirectToCheckout({
        sessionId: sessionId
    });
});
