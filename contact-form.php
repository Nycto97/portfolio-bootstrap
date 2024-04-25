<?php

/*
 * Bootstrap Portfolio
 * Portfolio website of Jelle Van Goethem.
 * Copyright (C) 2024 Jelle Van Goethem
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */

require_once realpath(__DIR__ . '/vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['SITE_KEY', 'SECRET_KEY'])->notEmpty();

// Google reCAPTCHA API key configuration
$siteKey = $_ENV['SITE_KEY'];
$secretKey = $_ENV['SECRET_KEY'];

// Email configuration
$toEmail = 'jelle.van.goethem@hotmail.com';
$fromName = $_POST['name'];
$fromEmail = $_POST['email'];

$postData = $statusMessage = $validationError = '';
$status = 'error';

// If the form is submitted
if (isset($_POST['submit'])) {
    // Get the submitted form data and trim whitespace
    $postData = $_POST;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate form fields
    if (empty($name)) {
        $validationError .= '- Please enter your name.\n';
    }
    if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $validationError .= '- Please enter a valid email.\n';
    }
    if (empty($subject)) {
        $validationError .= '- Please enter a subject.\n';
    }
    if (empty($message)) {
        $validationError .= '- Please enter a message.\n';
    }

    if (empty($validationError)) {
        // Validate reCAPTCHA box
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Verify the reCAPTCHA response
            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret=' .
                    $secretKey .
                    '&response=' .
                    $_POST['g-recaptcha-response']
            );

            // Decode json data
            $responseData = json_decode($verifyResponse);

            // If reCAPTCHA response is valid
            if ($responseData->success) {
                // prettier-ignore
                $htmlContent = "
                    <p><b>Name: </b>".$name."</p> 
                    <p><b>Email: </b>".$email."</p> 
                    <p><b>Subject: </b>".$subject."</p> 
                    <p><b>Message: </b>".$message."</p>
                ";

                // Always set content-type when sending HTML email
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
                // More headers
                $headers .= 'From:' . $fromName . ' <' . $fromEmail . '>' . "\r\n";

                // Send email
                @mail($toEmail, $subject, $htmlContent, $headers);

                $status = 'success';
                $statusMessage =
                    'Thank you! Your contact request has submitted successfully, I will get back to you soon.';
                $postData = '';
            } else {
                $statusMessage = 'Robot verification failed, please try again.';
            }
        } else {
            $statusMessage = 'Please check the reCAPTCHA box.';
        }
    } else {
        $statusMessage = 'Please fill in all mandatory fields:\n\n' . $validationError;
    }

    // prettier-ignore
    echo '
        <script>
            alert("'.$statusMessage.'");
            window.location.href = "index.html";
        </script>
    ';
}

?>
