<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// if error this will be printed
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// chech if email exist
if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ?')) {
		$stmt->bind_param('ss', $_GET['email']);
		$stmt->execute();
		
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			// Accout if there is with username
			if ($stmt = $con->prepare('UPDATE accounts WHERE email = ?')) {
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email']);
				$stmt->execute();
				echo 'Your account is now activated! You can now <a href="index.html">login</a>!';
			}
		} else {
			echo 'The account is already activated or doesn\'t exist!';
		}
	}
}
?>