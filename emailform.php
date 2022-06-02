<?php
	
/* SETUP */
	$set_email_to = "jelle.van.goethem@hotmail.com"; //Het email waar de mail naar verzonden wordt.
	$set_email_sender = "contactformulier@email.be"; //Het email vanwaar de mail komt
	$set_email_subject = "jQuery PHP Contact Form"; //Onderwerp van de email
	
/* Niet aanraken hieronder */
/* ======================================================================================================================= */
	
	function cleanPostVariables($input){			
	   /*$input = mysql_real_escape_string($input);*/
	   $input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
	   $input = strip_tags($input);
	   $input = stripslashes($input);
	   return $input;
	}

	$givenName = cleanPostVariables($_POST['name']);
	$givenEmail = cleanPostVariables($_POST['email']);
	//$givenSubject = cleanPostVariables($_POST['subject']);
	$givenMessage = cleanPostVariables($_POST['message']);
	
	$givenMessage = str_replace('<br />', PHP_EOL, $givenMessage); $set_email_sender
= $givenEmail; if(isset($givenName) && isset($givenMessage) /*&&
isset($givenSubject)*/ && isset($givenEmail)){ $to = $set_email_to; /*
"iemand@site.be, ander@site.be"; voor meerdere emails */ $subject =
$set_email_subject; $message = "
<html>
  <head>
    <title>".$set_email_subject."</title>
  </head>
  <body>
    <p>jQuery PHP Contact Form</p>
    <p>=============================</p>
    <br /><br />
    <p><strong>Naam & Voornaam: </strong> ".$givenName."</p>
    <p><strong>Email: </strong> ".$givenEmail."</p>
    <p><strong>Bericht: </strong></p>
    <p>".$givenMessage."</p>
    <br /><br />
    <p>Met vriendelijke groetjes</p>
    <p>Matijs</p>
  </body>
</html>
"; // Always set content-type when sending HTML email $headers = "MIME-Version:
1.0" . "\r\n"; $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; //
More headers $headers .= 'From: <'.$set_email_sender.'>' . "\r\n"; $headers .=
'Cc: '.$givenEmail.'' . "\r\n"; mail($to,$subject,$message,$headers); echo "ok";
}else{ echo "error"; } ?>