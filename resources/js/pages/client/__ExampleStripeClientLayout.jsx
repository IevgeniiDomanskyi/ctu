import { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { loadStripe } from '@stripe/stripe-js';
import { userLogout } from '@/store/auth';
import { billingSetupIndent, billingSavePaymentMethod } from '@/store/billing';

const ClientLayout = () => {
  const { me } = useSelector((state) => state.auth);
  const { indent } = useSelector((state) => state.billing);
  const dispatch = useDispatch();

  let stripe = null;
  let cardElement = null;

  const handleLogout = () => {
    dispatch(userLogout());
  };

  useEffect(() => {
    if (!indent.id) {
      dispatch(billingSetupIndent());
    } else {
      createStripeForm()
    }
  }, [indent]);

  const createStripeForm = async () => {
    stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
    const elements = stripe.elements();

    cardElement = elements.create('card', {
      hidePostalCode: true,
    });
    cardElement.mount('#card-element');
  }

  const handleCardSubmit = async () => {
    const cardHolderName = document.getElementById('card-holder-name');
    const { setupIntent, error } = await stripe.confirmCardSetup(
      indent.client_secret, {
        payment_method: {
          card: cardElement,
          billing_details: { name: cardHolderName.value }
        }
    });

    if (error) {
      console.log('error', error);
    } else {
      dispatch(billingSavePaymentMethod({
        payment_method: setupIntent.payment_method,
      }))
    }
  }

  return (
    <div className="client">
      { indent.id ? (
          <div>
            <input id="card-holder-name" type="text" />

            <div id="card-element"></div>

            <button id="card-button" onClick={handleCardSubmit}>
              Update Payment Method
            </button>

            <br /><br /><br />
          </div>
        ) : '' }

      {me.name} ({me.email})
      <br />
      <button onClick={handleLogout}>Log Out</button>
    </div>
  );
}

export default ClientLayout;