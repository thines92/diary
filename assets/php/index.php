<?php include("login.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Secret Diary</title>
	</head>
	<body>
	
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

	</body>
</html>