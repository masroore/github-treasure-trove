@extends('layouts.frontend')

@section('content')
<div class="container">
   @include('includes.cart_links')    
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="mb-4">Payment</h1>
            <!-- <div class="section-title-text">Insert some text right here related with the subject.<br>Pertinent info only.<br><br>Reminder: Insert some extra text right here.</div> -->
        </div>
        <div class="col-md-10 col-lg-6 mx-md-auto">
            <!-- <form class="checkout-payment-wrapper"> -->
                <p>Select Payment Method</p>
                <div class="d-flex mb-5 checkout-payment-method">
                    <input type="radio" id="stripe" value="stripe" name="payment-method" checked>
                    <label for="stripe" class="d-flex align-items-center justify-content-center"><img src="frontend_assets/img/stripe_logo.png" alt="STRIPE" width="80" height="25"></label>
                    <input type="radio" id="visa" value="visa" name="payment-method">
                    <label for="visa" class="d-flex align-items-center justify-content-center"><img src="frontend_assets/img/visa.svg" alt="VISA" width="80" height="25"></label>
                    <input type="radio" id="mastercard" value="mastercard" name="payment-method">
                    <label for="mastercard" class="d-flex align-items-center justify-content-center"><img src="frontend_assets/img/mastercard.svg" alt="VISA" width="75" height="45"></label>
                    <input type="radio" id="paypal" value="paypal" name="payment-method">
                    <label for="paypal" class="d-flex align-items-center justify-content-center"><img src="frontend_assets/img/paypal.svg" alt="VISA" width="140" height="36"></label>
                </div>

                 <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false"  data-stripe-publishable-key="{{($publisher_key) ? $publisher_key : ''}}" id="payment-form">
                        
                        @csrf      
                        <div class="checkout-payment-details">
                            <p class="mb-2">Cardholder name</p>
                            <div class="form-group form-floating mb-4">
                                <input type="text" class="form-control" id="nameInput" placeholder="Cardholder name">
                                <label for="nameInput">Cardholder name</label>
                            </div>

                             <p class="mb-2">Card number</p>
                            <div class="form-group form-floating mb-4">
                                <input type="text" class="form-control card-number" id="cardNumberInput" placeholder="0000-0000-0000-0000">
                                <label for="cardNumberInput">0000-0000-0000-0000</label>
                            </div>

                            <div class="d-flex">
                                <div class="mr-auto mr-md-5">
                                    <p class="mb-2">Expiration date</p>
                                    <div class="form-floating float-left">
                                        <select name="expireMonth" class="form-control custom-select expire-month">
                                            <option disabled selected value>Select</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                        <label for="expireMonth">Month</label>
                                    </div>
                                    <div class="form-floating float-left">
                                        <select name="expireYear" class="form-control custom-select expire-year">
                                            <option disabled selected value>Select</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                        <label for="expireYear">Year</label>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="mb-2">CVV</p>
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control card-cvc" id="cvvInput" placeholder="000">
                                        <label for="cvvInput">000</label>
                                    </div>
                                </div>
                            </div>

      
                            <div class="col-lg-6 px-0 mx-auto">
                                <button class="btn btn-primary  btn-lg btn-block" type="submit">Pay Now @if($final_price) (${{$final_price}}) @endif</button>
                                <br>

                                <a href="{{route('store')}}" target="_self"><button type="button" class="btn btn-warning  btn-lg btn-block">Continue Shopping</button></a>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');

        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
  
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.expire-month').val(),
            exp_year: $('.expire-year').val()
          }, stripeResponseHandler);
        }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>
@endsection