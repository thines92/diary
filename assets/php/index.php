<?php

	session_start(); // Allows for session variables and cookies

	$link = mysqli_connect("localhost", "thines92", "aidran001", "diary"); // Connects to database


	if ($_POST['submit'] == "Sign up") {

		/* ============= Email and Password Validation ===============*/

		if (!$_POST['email']) $error.="</br>Please enter your email";
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error.="</br>Please enter a valid email address";

		if (!$_POST['password']) $error.="</br>Please enter your password";
			else {
				if (strlen($_POST['password']) < 8) $error.="</br>Please enter a password with at least 8 characters";
				if (!preg_match('`[A-Z]`', $_POST['password'])) $error.="</br>Please include at least one capital letter in your password";
			}

		/* ============= Sign Up Code ============== */

		if ($error) echo "There were error(s) in your signup details:".$error;
		else {

			if (mysqli_connect_error()) die("Could not connect to database"); // check connection to database

			$query = "SELECT `email` FROM `users` WHERE `email`='".mysqli_real_escape_string/*USE THIS TO AVOID SQL INJECTION*/($link, $_POST['email'])."'"; // checks database for email that was submitted

			$result = mysqli_query($link, $query);

			$results = mysqli_num_rows($result); // Checks how many rows are returned.

			if ($results) echo "That email address is registered. Do you want to log in?"; // if results is truthy, then an email had been found
				else { // otherwise results is falsy and no email was found

					$query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".md5(md5($_POST['email']).$_POST['password'])."')";

					mysqli_query($link, $query); // Runs the query and inserts user into database

					echo "You've been signed up!";

					$_SESSION['id'] = mysqli_insert_id($link); // Makes a session variable using the new user's ID

					print_r($_SESSION); // Shows session variable

					// Redirect to logged in page

				}

		}

	}

	/* ============ Log In Code ===========*/

	if ($_POST['submit'] == "Log in") {

			if (mysqli_connect_error()) die("Could not connect to database");

			$query = "SELECT `email` FROM `users` WHERE `email`='".mysqli_real_escape_string($link, $_POST['loginEmail'])."' AND password='".md5(md5($_POST['loginEmail']).$_POST['loginPassword'])."' LIMIT 1";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_array($result);

			print_r($row);

	}

?>

<form method="post">
	
	<input type="email" name="email" id="email" value="<?php echo addslashes($_POST['email']); ?>"/>

	<input type="password" name="password" id="password" />

	<input type="submit" name="submit" value="Sign up" />

</form>

<form method="post">
	
	<input type="email" name="loginEmail" id="loginEmail" value="<?php echo addslashes($_POST['loginEmail']); ?>"/>

	<input type="password" name="loginPassword" id="loginPassword" />

	<input type="submit" name="submit" value="Log in" />

</form>