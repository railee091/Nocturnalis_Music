<?php

//payment.php

include('database_connection.php');

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

if(isset($_POST["token"]))
{
 require_once 'stripe-php/init.php';

 \Stripe\Stripe::setApiKey('sk_test_51IERoJDZd4eRZajoupp7fsmUZzDNiaatbNJrIGpXsT0FQc0fevWfzJB4krx013BUCKvDxUZFmZzLdX0CFTIwrUp800SYhmwYEj'); //change only within '' for stripe sk_live key

 $customer = \Stripe\Customer::create(array(
  'email'   => $_POST["email_address"],
  'source'  => $_POST["token"],
  'name'   => $_POST["customer_name"],
  'address'  => array(
   'line1'   => $_POST["customer_address"],
   'postal_code' => $_POST["customer_pin"],
   'city'   => $_POST["customer_city"],
   'state'   => $_POST["customer_state"],
   'country'  => 'US'
  )
 ));

 $order_number = rand(100000,999999);

 $charge = \Stripe\Charge::create(array(
  'customer'  => $customer->id,
  'amount'  => $_POST["total_amount"] * 100,
  'currency'  => $_POST["currency_code"],
  'description' => $_POST["item_details"],
  'metadata'  => array(
   'order_id'  => $order_number
  )
 ));

 $response = $charge->jsonSerialize();

 if($response["amount_refunded"] == 0 && empty($response["failure_code"]) && $response['paid'] == 1 && $response["captured"] == 1 && $response['status'] == 'succeeded')
 {
  $amount = $response["amount"]/100;

  $order_data = array(
   ':order_number'   => $order_number,
   ':order_total_amount' => $amount,
   ':transaction_id'  => $response["balance_transaction"],
   ':card_cvc'    => $_POST["card_cvc"],
   ':card_expiry_month' => $_POST["card_expiry_month"],
   ':card_expiry_year'  => $_POST["card_expiry_year"],
   ':order_status'   => $response["status"],
   ':card_holder_number' => $_POST["card_holder_number"],
   ':email_address'  => $_POST['email_address'],
   ':customer_name'  => $_POST["customer_name"],
   ':customer_address'  => $_POST['customer_address'],
   ':customer_city'  => $_POST['customer_city'],
   ':customer_pin'   => $_POST['customer_pin'],
   ':customer_state'  => $_POST['customer_state'],
   ':customer_country'  => $_POST['customer_country']
  );

  $query = "
  INSERT INTO order_table 
     (order_number, order_total_amount, transaction_id, card_cvc, card_expiry_month, card_expiry_year, order_status, card_holder_number, email_address, customer_name, customer_address, customer_city, customer_pin, customer_state, customer_country) 
     VALUES (:order_number, :order_total_amount, :transaction_id, :card_cvc, :card_expiry_month, :card_expiry_year, :order_status, :card_holder_number, :email_address, :customer_name, :customer_address, :customer_city, :customer_pin, :customer_state, :customer_country)
  ";

  $statement = $connect->prepare($query);

  $statement->execute($order_data);

  $order_id = $connect->lastInsertId();

  foreach($_SESSION["shopping_cart"] as $keys => $values)
  {
   $order_item_data = array(
    ':order_id'  => $order_id,
    ':order_item_name' => $values["product_name"],
    ':order_item_quantity' => $values["product_quantity"],
    ':order_item_price' => $values["product_price"]
   );

   $query = "
   INSERT INTO order_item 
   (order_id, order_item_name, order_item_quantity, order_item_price) 
   VALUES (:order_id, :order_item_name, :order_item_quantity, :order_item_price)
   ";

   $statement = $connect->prepare($query);

   $statement->execute($order_item_data);
  }

  unset($_SESSION["shopping_cart"]);
  $file=$values["product_name"];
  $customerEmail=$_POST['email_address'];
  $customerName=$_POST['customer_name'];
  $customerItemPrice=$values["product_price"];
  $_SESSION["success_message"] = "Payment is completed successfully. The TXN ID is " . $response["balance_transaction"] . "";
  
  $_SESSION['fileDownload'] = $file;
  $_SESSION['customerEmail'] = $customerEmail;
  $_SESSION['customerName'] = $customerName;
  $_SESSION['customerItemPrice'] = $customerItemPrice;
  $_SESSION['order_number'] = $order_number;

  $mail = new PHPMailer(true);
  $senderMessage = "a purchase has been made for:<br/><b>Album:</b>".$file."<br/><b>Name:</b>".$customerName."<br/>"."<b>Email:</b>".$customerEmail."<br/>Order No.:".$order_number;
  //this part to send email to nocturnalis email
  try {
      // Server settings
      //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      require_once('emailkeys/emailpasswords.php');

      // Sender and recipient settings
      $mail->setFrom($websiteEmailAddress, 'Nocturnalis Music');
      $mail->addAddress($websiteEmailAddress, 'Nocturnalis Music');
      $mail->addReplyTo($customerEmail, $customerName); // to set the reply to

      // Setting the email content
      $mail->IsHTML(true);
      $mail->Subject = "Purchase made from ".$customerEmail;
      $mail->Body = $senderMessage;//'HTML message body. <b>Gmail</b> SMTP email body.';
      $mail->AltBody = $senderMessage;//'Plain text message body for non-HTML email client. Gmail SMTP email body.';

      $mail->send();
      //echo "Email message sent.";
  } catch (Exception $e) {
      //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
  }
  $txt = $customerEmail;
  $myfile = file_put_contents('3m@1Lk3y5/Purchase_3m@1L_L15t.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
  header('location:success_download');
 }

}

?>
