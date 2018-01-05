<?php

// define variables and set to empty values
$name_error = $last_name_error = $email_error = $message_error = "";
$name = $last_name = $email = $message  = $success = "";

//  Validation
if (empty($_POST["name"])) {
    $name_error = "Your Name is required";
  } else {
    $name = test_input($_POST["name"]);
	// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $name_error = "Only letters and white space allowed"; 
    }
  }
  
if (empty($_POST["last_name"])) {
    $last_name_error = "Your Last Name is required";
  } else {
    $last_name = test_input($_POST["last_name"]);
	// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $last_name_error = "Only letters and white space allowed"; 
    }
  }
  
  if (empty($_POST["email"])) {
    $email_error = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Invalid email format"; 
    }
  }
  
  if (empty($_POST["message"])) {
    $message = "Write some message";
  } else {
    $message = test_input($_POST["message"]);
  }



$msg = '';
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');

    require '../PHPMailerAutoload.php';

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->Port = 25;

    $mail->setFrom($_POST['email']);
    $mail->addAddress('artitup@artitupteam.com');
	
    if ($mail->addReplyTo($_POST['email'], $_POST['name'], $_POST['last_name'])) {
        $mail->Subject = 'Art It Up mail';
		
        $mail->isHTML(false);
		
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Last_Name: {$_POST['last_name']}
Message: {$_POST['message']}
EOT;

        if (!$mail->send()) {
			
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Message sent! Thanks for contacting us. We will get in touch with you shortly.';
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact form</title>
</head>
<body>
<h1>Contact us</h1>
<?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>
<form method="POST">
    <label for="name">Name: <input type="text" name="name" id="name"></label><br>
    <label for="last_name">Last Name: <input type="text" name="last_name" id="last_name"></label><br>
    <label for="email">Email address: <input type="email" name="email" id="email"></label><br>
    <label for="message">Message: <textarea name="message" id="message" rows="8" cols="20"></textarea></label><br>
    <input type="submit" value="Send">
</form>
</body>
</html>
