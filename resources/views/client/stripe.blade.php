<!DOCTYPE html>
<html>
<head>
	<title>Payment Gateway</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style type="text/css">
        .container {
            
            margin-top: 40px;
        }

        }
        h1{
            font-size:30px;
            font-weight:600;
            margin-top:20px;
            margin-bottom:50px;
        }
        h2{
            font-size:22px;
            font-weight:600;
            margin-top:20px;
            margin:auto;
            margin-bottom:30px;
        }
        .block-center{
            text-align:center;
        }
        .option{
            font-weight:500;
            margin: 10px 10px 10px 10px;
        } 
        input{
            margin:0px 10px 10px 10px;
        }
    </style>
</head>
<body>
    
<div class="container">  
    <h1 align="center">How would you like to pay?</h1>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">  
                    
                    <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="payment-form">
                        @csrf
                        <input type="hidden" id="purchase_list" name="purchase_list">
                        <input type="hidden" id="restaurantID" name="restaurantID">
                        <input type="hidden" id="userID" name="userID">
                        <input type="hidden" id="tot_price" name="tot_price">
                        <div class='form-row row'>
                            <div class="option"> 
                                <input id="card" type="radio" checked name="payment-method">
                                <label for="card">Pay with Card</label>
                            </div>
                            
                            <div id="card_payment" class='form-row row'>
                                <div class='col-xs-10 col-md-offset-1 form-group'>
                                    <label class='control-label'>Security Number </label> 
                                    <input
                                        autocomplete='off' class='form-control card-num'
                                        type='text'>
                                    <p>The 3 digit numbers on the back of your card</p>
                                </div>
                            </div>

                            <div class="option"> 
                                <input id="cash" type="radio" name="payment-method">
                                <label for="cash">Pay with Cash</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                @if (Session::has('success'))
                                    <button class="btn btn-primary btn-lg btn-block" id="close" type="button">Return </button>    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                @else    
                                    <button class="btn btn-danger btn-lg btn-block" id="checkout" type="button">Place Order</button>
                                @endif
                                
                            </div>
                        </div>                         
                    </form>
                </div>
            </div>        
        </div>

        <div class="col-md-4 col-md-offset-1 block-center">
            <h2>Your Order</h2>
            <table class="table table-striped">
                <thead align="center">
                  <tr class="table-active" style="font-weight:600;font-size:20px">
                    <td>Item</td>
                    <td>Quantity</td>
                    <td>Price</td>
                  </tr>
                </thead>
                <tbody id="itemTable" align="center">
                
                </tbody>
            </table>
        </div> 
    </div>
</div>
  
</body>
  
<script>
    $(document).ready(function(){

        @if (Session::has('success'))
            sessionStorage.setItem("total",0);
            sessionStorage.setItem("MyPurchase",[]);
        @endif

        $('#purchase_list').val(sessionStorage.getItem("MyPurchase"));
        $('#restaurantID').val(sessionStorage.getItem("restaurantID"));
        $('#userID').val(sessionStorage.getItem("userID"));
        $('#tot_price').val(sessionStorage.getItem("total"));

        myPur = JSON.parse(sessionStorage.getItem('MyPurchase'));
        myPur.forEach((item)=>{
            $('#itemTable').append(`<tr><td>${item.itemN}</td><td>${item.itemQ}</td><td>$${item.itemP*item.itemP}</td></tr>`);
        });
        $('#itemTable').append(`<tr><td><b>Total</b></td><td></td><td>$${sessionStorage.getItem("total")}</td></tr>`);


        const charge = sessionStorage.getItem("total");
        $("#payment-form").append(`<input type="hidden" name="chargeAmount" value=${charge} >`);

        $('#card').click(()=>{
            $('#card_payment').show();
        });
        $('#cash').click(()=>{
            $('#card_payment').hide();
        })


    })
</script>


  
<script type="text/javascript">
$(function() {
    var $form         = $(".validation");
  $('form.validation').bind('submit', function(e) {
    var $form         = $(".validation"),
        inputVal = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputVal),
        $errorStatus = $form.find('div.error'),
        valid         = true;
        $errorStatus.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorStatus.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-num').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeHandleResponse);
    }
  
  });
  
  function stripeHandleResponse(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

    var stripe = Stripe("pk_test_51I1pQLIQCvJBDzwkaY9FcOBhfAAg8FRIb9odVeSKkbZut78oHYNGhU6V7ofgBJzn9V2kfLC38b22szElQ2JVfmoT00XhFUJ5gr");

    var checkoutButton = document.getElementById("checkout");
    checkoutButton.addEventListener("click", function () {
      fetch("/final_single_food/Stripe.php", {
        method: "POST",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        // .then(function (result) {
        //   // If redirectToCheckout fails due to a browser or network
        //   // error, you should display the localized error message to your
        //   // customer using error.message.
        //   if (result.error) {
        //     alert(result.error.message);
        //   }
        // })
        .catch(function (error) {
          console.error("Error:", response);
        });
    });
  
});
</script>
</html>