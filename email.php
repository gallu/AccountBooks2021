<?php   // email.php

//echo "email\n";
$to_address = 'XXXXXX';

//$r = mail($to_address, 'Subject', 'Message string');
//var_dump($r);

//
require_once('./vendor/autoload.php');

// Create the Transport
$transport = new Swift_SmtpTransport('localhost', 25);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['furu@dev2.m-fr.net' => 'furu'])
  ->setTo($to_address)
  ->setBody('Here is the message itself')
;

// Send the message
$result = $mailer->send($message);
var_dump($result);





