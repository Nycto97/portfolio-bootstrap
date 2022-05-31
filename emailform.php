<!-- <?php
if (isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "jelle.van.goethem@hotmail.com";
    $email_subject = "New form submissions";

    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

    Thank you for contacting us. We will be in touch with you very soon.

<?php
}
?> -->






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