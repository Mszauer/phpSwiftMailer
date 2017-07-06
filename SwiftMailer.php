<?php
require_once __DIR__ . '/includes/config.php';

$html = <<<EOT
!<!DOCTYPE html>
<html>
<head>
<title>Swift Mailer test</title>
</head>
<body>
<p>This is an html email sent from swift mailer!</p>
</body>
</html>
EOT;

$text = <<<EOT
HTML Email sent with Swift Mailer.

to use html, just simply use the setBody() method of the message object, and set the second argument to this fallback txt version.
For more information visit the swiftmailer documentation.
EOT;

try{
	//options
	$priority = '1';
	$priority = (int)$priority;
	$requestReceipt = true;

	//create message
	$message = (new Swift_Message())
		->setSubject('Test of Swift mailer Encrypted')
		->setFrom($from)
		->setTo(['test@test.com' => 'Testing']) //another option is to create an array of recepients and loop through them. ['email'=>'name'] or [number of recipient => email]. Do this at the end before you send, after creating the transporter and user mailer->send in the loop for each person
		->addCc([$test2,'Test Account2')
		->setBody($html, 'text/html')
		->addPart($text, 'text/plain');

	// attach a file
	$imagePath = '';//insert image path here
	$attachment = Swift_Attachment::fromPath($imagePath);
	$attachment->setFilename('image.png');
	$message->attach($attachment);

	//validate email
	$email = 'text@example.com';
	if(Swift_Validate::email($email)){
		$message->setReplyTo($email);
	}

	// set priority
	if($priority >= 1 && $priority <= 5){
		$message->setPriority($priority);
	}

	//request read receipt
	if($requestReceipt){
		if(Swift_Validate::email($email)){
			$message->setReadReceiptTo($email)
		}
	}

	//add custom header
	$headers = $message->getHeaders();
	$headers->addTextHeader('X-PHP-VERSION', phpversion());

	//display message in the web
	echo $message->toString();

	//create a transport using an aggregate fallback
	$nonexistent = (new Swift_SmptpTransport('mail.example.com'));
	$transport = (new Swift_SmptpTransport($smtp_server,465,'ssl'))
		->setUsername($username)
		->setPassword($password);
	//$transport = (new Swift_SendmailTransport('/usr/sbin/sendmail -bs')); //smtp backup
	$aggregate = (new Switft_FailoverTransport([$nonexistent,$transport]));

	//create the mailer
	$mailer = (new Swift_Mailer($aggregate));

	//send email
	$result = $mailer->send($message);

	//echo confirmation
	if($result){
		echo "Number of emails sent: $result";
	} else{
		echo 'Could not send email';
	}
} catch(Exception $e){
	echo $e->getMessage();
}
