<?php
require_once 'Mail.php'; //This is a class that you get from pear.

//Our function to send mail to our recipient.
function sendMail($tasks, $name, $recipientEmail) {

	//Static Variables
	$FROM_NAME=""; //Name of the person you're sending from.
	$FROM_EMAIL=""; //Email of the person you're sending from.
	$HOST = "";   //This is your SMTP server host.
	$PORT = "";                          //This is your SMTP server host port.
	$USERNAME = "";    //This is your SMTP server login.
	$PASSWORD = "";		 //This is your SMTP server password.


	$from = "$FROM_NAME <$FROM_EMAIL>";
	$to = "$name <$recipientEmail>";
	$subject = "You failed to complete some tasks today.\r\n\r\n";
	$body = $tasks;

	$headers = array ('From' => $from,
  	'To' => $to,
  	'Subject' => $subject);
	$smtp = Mail::factory('smtp',
  	array ('host' => $HOST,
    	'port' => $PORT,
    	'auth' => true,
    	'username' => $USERNAME,
    	'password' => $PASSWORD));

	$mail = $smtp->send($to, $headers, $body);

	if (PEAR::isError($mail)) {
  		echo($mail->getMessage());
	} else {
 		 return "success";
	}
}
?>
