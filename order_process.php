<?php

//order_process.php

session_start();

$total_price = 0;

$item_details = '';

$order_details = '
<div class="table-responsive" id="order_table">
 <table class="table table-bordered table-striped">
  <tr>  
            <th>Product Name</th>  
            <th>Quantity</th>  
            <th>Price</th>  
            <th>Total</th>  
        </tr>
';

if(!empty($_SESSION["shopping_cart"]))
{
 foreach($_SESSION["shopping_cart"] as $keys => $values)
 {
  $order_details .= '
  <tr>
   <td>'.$values["product_name"].'</td>
   <td>'.$values["product_quantity"].'</td>
   <td align="right">$ '.$values["product_price"].'</td>
   <td align="right">$ '.number_format($values["product_quantity"] * $values["product_price"], 2).'</td>
  </tr>
  ';
  $total_price = $total_price + ($values["product_quantity"] * $values["product_price"]);

  $item_details .= $values["product_name"] . ', ';
 }
 $item_details = substr($item_details, 0, -2);
 $order_details .= '
 <tr>  
        <td colspan="3" align="right">Total</td>  
        <td align="right">$ '.number_format($total_price, 2).'</td>
    </tr>
 ';
}else{
  header('location:index');
}
$order_details .= '</table>';

?>

<!DOCTYPE html>
<html>
 <head>
  <title>NocturNalis Music</title>
  <meta name="description" content="An electronic musical odyssey detailing the saga of Shadelsin Dakraedow.
By Chris Kochesky and Zælous X. The progenitors of the Electro-Dungeon genre.">
  <meta name="author" content="NocturNalis Music">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="icon" href="images/favicon-32x32.png">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/owl.theme.css">
  <link rel="stylesheet" href="css/owl.carousel.css">

  <!-- Main css -->
  <link rel="stylesheet" href="css/style2.css">

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.parallax.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/smoothscroll.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="https://js.stripe.com/v2/"></script>
  <script src="js/jquery.creditCardValidator.js"></script>
  <style>
  .popover
  {
      width: 100%;
      max-width: 800px;
  }
  .require
  {
   border:1px solid #FF0000;
   background-color: #cbd9ed;
  }
  </style>
 </head>
 <body>
  <!-- =========================
     NAVIGATION LINKS     
============================== -->
<div class="navbar navbar-fixed-top custom-navbar" role="navigation">
  <div class="container">

    <!-- navbar header -->
    <div class="navbar-header">
      <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
      </button>
      <a href="index" class="navbar-brand">NocturNalis Music</a>
    </div>

    <div class="collapse navbar-collapse">

      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="index" class="smoothScroll">HOME</a>
        </li>
      </ul>

    </div>

  </div>
</div>
  <div class="container">
   <br />
   <br />
   <br />
   <br />
     <div class="row">
      <div style="display: table; margin: auto;">
          <span class="step step_complete_1"> <a href="#" class="check-bc">Cart</a> <span class="step_line step_complete"> </span> <span class="step_line backline"> </span> </span>
          <span class="step step_complete"> <a href="#" class="check-bc">Checkout</a> <span class="step_line "> </span> <span class="step_line step_complete"> </span> </span>
          <span class="step_download check-bc step_complete">Download</span>
      </div>
  </div>
   <h3 align="center"><a href="#">Complete Payment details and submit to download</a></h3>
   <br />
   <span id="message"></span>
   <div class="panel panel-default">
    <div class="panel-heading">Order Process</div>
    <div class="panel-body">
     <form method="post" id="order_process_form" action="payment.php">
      <div class="row">
       <div class="col-md-8" style="border-right:1px solid #ddd;">
        <h4 align="center">Customer Details</h4>
        <div class="form-group">
         <label><b>Card Holder Name <span class="text-danger">*</span></b></label>
               <input type="text" name="customer_name" id="customer_name" class="form-control" value="" />
               <span id="error_customer_name" class="text-danger"></span>
           </div>
           <div class="form-group">
            <label><b>Email Address <span class="text-danger">*</span></b></label>
            <input type="text" name="email_address" id="email_address" class="form-control" value="" />
            <span id="error_email_address" class="text-danger"></span>
           </div>
           <div class="form-group">
            <label><b>Address <span class="text-danger">*</span></b></label>
            <textarea name="customer_address" id="customer_address" class="form-control"></textarea>
            <span id="error_customer_address" class="text-danger"></span>
           </div>
           <div class="row">
            <div class="col-sm-6">
             <div class="form-group">
              <label><b>City <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_city" id="customer_city" class="form-control" value="" />
              <span id="error_customer_city" class="text-danger"></span>
             </div>
            </div>
            <div class="col-sm-6">
             <div class="form-group">
              <label><b>Zip <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_pin" id="customer_pin" class="form-control" value="" />
              <span id="error_customer_pin" class="text-danger"></span>
             </div>
            </div>
           </div>
           <div class="row">
            <div class="col-sm-6">
             <div class="form-group">
              <label><b>State </b></label>
              <input type="text" name="customer_state" id="customer_state" class="form-control" value="" />
             </div>
            </div>
            <div class="col-sm-6">
             <div class="form-group">
              <label><b>Country <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_country" id="customer_country" class="form-control" />
              <span id="error_customer_country" class="text-danger"></span>
             </div>
            </div>
           </div>
           <hr />
           <h4 align="center"><img src="images/secure-stripe-payment-logo.png" width="30%"></h4>
           <div class="form-group">
                  <span id="message"></span><!--stripe's error message-->
                  <label>Card Number <span class="text-danger">*</span></label>
                  <input type="text" name="card_holder_number" id="card_holder_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="20" onkeypress="" />
                  <span id="error_card_number" class="text-danger"></span>
              </div>
              <div class="form-group">
                 <div class="row">
                  <div class="col-md-4">
                    <label for="exampleFormControlSelect1">Expiry Month</label>
                    <select class="form-control" name="card_expiry_month" id="card_expiry_month" class="form-control" placeholder="MM" maxlength="2" onkeypress="return only_number(event);" >
                      <option value="" disabled selected hidden>MM</option>
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                    </select>
                    <span id="error_card_expiry_month" class="text-danger"></span>
                   <!--<label>Expiry Month</label>

                   <input type="text" name="card_expiry_month" id="card_expiry_month" class="form-control" placeholder="MM" maxlength="2" onkeypress="return only_number(event);" />
                   <span id="error_card_expiry_month" class="text-danger"></span>-->
                  </div>
                  <div class="col-md-4">
                   <label>Expiry Year</label>
                   <input type="text" name="card_expiry_year" id="card_expiry_year" class="form-control" placeholder="YYYY" maxlength="4" onkeypress="return only_number(event);" />
                   <span id="error_card_expiry_year" class="text-danger"></span>
                  </div>
                  <div class="col-md-4">
                   <label>CVC</label>
                   <input type="text" name="card_cvc" id="card_cvc" class="form-control" placeholder="123" maxlength="4" onkeypress="return only_number(event);" />
                   <span id="error_card_cvc" class="text-danger"></span>
                  </div>
                 </div>
              </div>
              <br />
        <div align="center">
         <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>" />
         <input type="hidden" name="currency_code" value="USD" />
         <input type="hidden" name="item_details" value="<?php echo $item_details; ?>" />
         <input type="button" name="button_action" id="button_action" class="btn btn-success btn-sm" onclick="stripePay(event)" value="Pay Now" />
        </div>
        <br />
       </div>
       <div class="col-md-4">
        <h4 align="center">Order Details</h4>
        <?php
        echo $order_details;
        ?>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </body>
</html>

<script>

function validate_form()
{
 var valid_card = 0;
 var valid = false;
 var card_cvc = $('#card_cvc').val();
 var card_expiry_month = $('#card_expiry_month').val();
 var card_expiry_year = $('#card_expiry_year').val();
 var card_holder_number = $('#card_holder_number').val();
 var email_address = $('#email_address').val();
 var customer_name = $('#customer_name').val();
 var customer_address = $('#customer_address').val();
 var customer_city = $('#customer_city').val();
 var customer_pin = $('#customer_pin').val();
 var customer_country = $('#customer_country').val();
 var name_expression = /^[a-z ,.'-]+$/i;
 var email_expression = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
 var month_expression = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
 var year_expression = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
 var cvv_expression = /^[0-9]{3,3}$/;

 $('#card_holder_number').validateCreditCard(function(result){
  if(result.valid)
  {
   $('#card_holder_number').removeClass('require');
   $('#error_card_number').text('');
   valid_card = 1;
  }
  else
  {
   $('#card_holder_number').addClass('require');
   $('#error_card_number').text('Invalid Card Number');
   valid_card = 0;
  }
 });

 if(valid_card == 1)
 {
  if(!month_expression.test(card_expiry_month))
  {
   $('#card_expiry_month').addClass('require');
   $('#error_card_expiry_month').text('Invalid Data');
   valid = false;
  }
  else
  { 
   $('#card_expiry_month').removeClass('require');
   $('#error_card_expiry_month').text('');
   valid = true;
  }

  if(!year_expression.test(card_expiry_year))
  {
   $('#card_expiry_year').addClass('require');
   $('#error_card_expiry_year').error('Invalid Data');
   valid = false;
  }
  else
  {
   $('#card_expiry_year').removeClass('require');
   $('#error_card_expiry_year').error('');
   valid = true;
  }

  if(!cvv_expression.test(card_cvc))
  {
   $('#card_cvc').addClass('require');
   $('#error_card_cvc').text('Invalid Data');
   valid = false;
  }
  else
  {
   $('#card_cvc').removeClass('require');
   $('#error_card_cvc').text('');
   valid = true;
  }
  if(!name_expression.test(customer_name))
  {
   $('#customer_name').addClass('require');
   $('#error_customer_name').text('Invalid Name');
   valid = false;
  }
  else
  {
   $('#customer_name').removeClass('require');
   $('#error_customer_name').text('');
   valid = true;
  }

  if(!email_expression.test(email_address))
  {
   $('#email_address').addClass('require');
   $('#error_email_address').text('Invalid Email Address');
   valid = false;
  }
  else
  {
   $('#email_address').removeClass('require');
   $('#error_email_address').text('');
   valid = true;
  }

  if(customer_address == '')
  {
   $('#customer_address').addClass('require');
   $('#error_customer_address').text('Enter Address Detail');
   valid = false;
  }
  else
  {
   $('#customer_address').removeClass('require');
   $('#error_customer_address').text('');
   valid = true;
  }

  if(customer_city == '')
  {
   $('#customer_city').addClass('require');
   $('#error_customer_city').text('Enter City');
   valid = false;
  }
  else
  {
   $('#customer_city').removeClass('require');
   $('#error_customer_city').text('');
   valid = true;
  }

  if(customer_pin == '')
  {
   $('#customer_pin').addClass('require');
   $('#error_customer_pin').text('Enter Zip code');
   valid = false;
  }
  else
  {
   $('#customer_pin').removeClass('require');
   $('#error_customer_pin').text('');
   valid = true;
  }

  if(customer_country == '')
  {
   $('#customer_country').addClass('require');
   $('#error_customer_country').text('Enter Country Detail');
   valid = false;
  }
  else
  {
   $('#customer_country').removeClass('require');
   $('#error_customer_country').text('');
   valid = true;
  }

  
 }
 return valid;
}

Stripe.setPublishableKey('pk_test_51IERoJDZd4eRZajoFjKL1i6YjZzegtyyysFfWnFyqFxhmvTpcLXAvmKS9RocJJG11lkMIKIoHPyp8GBUmkhzlecM00ltOuUu10');//change only within '' for stripe pk_live key

function stripeResponseHandler(status, response)
{
 if(response.error)
 {
  $('#button_action').attr('disabled', false);
  $('#message').html(response.error.message).show();
 }
 else
 {
  var token = response['id'];
  $('#order_process_form').append("<input type='hidden' name='token' value='" + token + "' />");

  $('#order_process_form').submit();
 }
}

function stripePay(event)
{
 event.preventDefault();
 
 if(validate_form() == true)
 {
  $('#button_action').attr('disabled', 'disabled');
  $('#button_action').val('Payment Processing....');
  Stripe.createToken({
   number:$('#card_holder_number').val(),
   cvc:$('#card_cvc').val(),
   exp_month : $('#card_expiry_month').val(),
   exp_year : $('#card_expiry_year').val()
  }, stripeResponseHandler);
  return false;
 }
}


function only_number(event)
{
 var charCode = (event.which) ? event.which : event.keyCode;
 if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
 {
  return false;
 }
 return true;
}

</script>