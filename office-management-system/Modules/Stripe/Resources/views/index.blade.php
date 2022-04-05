@extends('backEnd.master')
@section('mainContent')

        <!--/ menu  -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('stripe.process') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="card">
                        <div class="card-header">@lang('account.Stripe Checkout')</div>

                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            
                            <hr />
                        
                            <input type="hidden" name="sale_id" value="{{ request()->get('sale_id') }}">
                            <input type="hidden" name="amount" value="{{ request()->get('amount') }}">
                            <input type="hidden" name="payment-method" id="payment-method" value="">

                            <div class="row">
                              <div class="col-md-4">
                                  @lang('account.Card Holder Name') :
                                  <br />
                                  <input name="card-holder-name" class="form-control" type="text">
                              </div>
                          </div>

                            <hr>

                            <!-- Stripe Elements Placeholder -->
                            <div id="card-element"></div>

                            <hr>
                            <div id="card-errors" role="alert"></div>
                            <button id="card-button" class="primary-btn fix-gr-bg btn-copy">
                                @lang('account.Pay')
                            </button>
                        
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
<!-- main content part end -->

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
   var stripe = Stripe("{{ $stripeKey }}");
  
// Create an instance of Elements.
var elements = stripe.elements();
  
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
  
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
  
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
  
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});
  
// Handle form submission.
var form = document.getElementById('checkout-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
  
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});
  
// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('checkout-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
  
    // Submit the form
    form.submit();
}
</script>

@endpush
