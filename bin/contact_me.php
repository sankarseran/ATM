<?php
// If you are using Composer
require 'vendor/autoload.php';

// If you are not using Composer (recommended)
//require("/sendgrid-php/sendgrid-php.php");


// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['address'])    ||
   empty($_POST['yarn'])      ||
   empty($_POST['product'])   ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
  else{ 
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$address= strip_tags(htmlspecialchars($_POST['address']));
$yarn= strip_tags(htmlspecialchars($_POST['yarn']));
$product= strip_tags(htmlspecialchars($_POST['product']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
//// Create the email and send the message
//$to = 'sankaralingam.psg@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
//$email_subject = "Website Contact Form:  $name";
//$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nYarn:$yarn\n\nProduct:$product\n\nMessage:\n$message";
//$headers = "From: sankaralingam.psg@gmail.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
//$headers .= "Reply-To: $email_address";   
//$mail = new SendGrid\Mail($from, $subject, $to, $email_body, $headers); hii
$mailid = getenv('MAIL_ID');
echo "mail id is".$mailid;
$from = new SendGrid\Email(null, $mailid);
$subject = "Website Contact Form:  $name";
$to = new SendGrid\Email(null, $mailid);
$content = new SendGrid\Content("text/plain", "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nYarn:$yarn\n\nProduct:$product\n\nMessage:\n$message");
$mail = new SendGrid\Mail($from, $subject, $to, $content);


$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);
try{
$response = $sg->client->mail()->send()->post($mail);
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//echo $response->statusCode();
//echo $response->body();
//echo $response->headers();
return true;	
  }
?>
