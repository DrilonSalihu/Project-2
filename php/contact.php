<?php
  $from = 'Salihu Marketing - Site Contact <hi@salihumarketing.com>'; // this is used in the "From" field of the email
  $sendTo = 'Salihu Marketing - Site Contact <hi@salihumarketing.com>'; // email receiver
  $subject = 'New message from contact form'; // email subject
  $fields = array('name' => 'Name', 'surname' => 'Surname', 'need' => 'Need', 'email' => 'Email', 'message' => 'Message'); 
  $successfulMessage = 'The email was sent successfully. Thank you!'; // message sent successfully
  $failedMessage = 'There was an error sending your email. Please try again later.'; // message failed to be sent

  try
  {
      if(count($_POST) == 0) throw new \Exception('Form is empty');
              
      $emailText = "A visitor has used the site's contact form and sent a new message:\n\n";

      foreach ($_POST as $key => $value) 
      {
          // if the field exists in the $fields array, include it in the email 
          if (isset($fields[$key])) {
              $emailText .= "$fields[$key]: $value\n";
          }
      }

      // email headers
      $headers = array('Content-Type: text/plain; charset="UTF-8";',
          'From: ' . $from,
          'Reply-To: ' . $from,
          'Return-Path: ' . $from,
      );
      
      // Send email
      mail($sendTo, $subject, $emailText, implode("\n", $headers));
      $responseArray = array('type' => 'success', 'message' => $successfulMessage);
  }
  catch (\Exception $e)
  {
      $responseArray = array('type' => 'danger', 'message' => $failedMessage);
  }


  // returns a JSON response if an AJAX request has been made
  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $encoded = json_encode($responseArray);

      header('Content-Type: application/json');

      echo $encoded;
  }
  // if not, returns to main page
  else 
  {
    header("Location: /company-website");
  }
?>