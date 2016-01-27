<?php

	if ($_POST['submit']) {

		if (!$_POST['email']) $error.="</br>Please enter your email";
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error.="</br>Please enter a valid email address";

		if (!$_POST['password']) $error.="</br>Please enter your password";
			else {
				if (strlen($_POST['password']) < 8) $error.="</br>Please enter a password with at least 8 characters";
				if (!preg_match('`[A-Z]`', $_POST['password'])) $error.="</br>Please include at least one capital letter in your password";
			}

		if ($error) echo "There were error(s) in your signup details:".$error;
		else {

			$link = mysqli_connect("localhost", "thines92", "aidran001", "diary"); //connect to database

			if (mysqli_connect_error()) die("Could not connect to database"); // check connection to database

			$query = "SELECT `email` FROM `users` WHERE `email`='".mysqli_real_escape_string/*USE THIS TO AVOID SQL INJECTION*/($link, $_POST['email'])."'"; // checks database for email that was submitted

			$result = mysqli_query($link, $query);

			$results = mysqli_num_rows($result); // Checks how many rows are returned.

			if ($results) echo "That email address is already in use."; // if results is truthy, then an email had been found
				else { // otherwise results is falsy and no email was found

					$query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".md5(md5($_POST['email']).$_POST['password'])."')";

					mysqli_query($link, $query); // Runs the query

					echo "You've been signed up!";

				}

		}

	}

?>

<form method="post">
	
	<input type="email" name="email" id="email" />

	<input type="password" name="password" id="password" />

	<input type="submit" name="submit" value="Sign Up" />

</form>