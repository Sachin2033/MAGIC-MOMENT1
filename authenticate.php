<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
//connecting database 
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If erroe this is printed
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// check if data is inserted
if ( !isset($_POST['username'], $_POST['password']) ) {
	// check if anything is empty
	exit('Please fill both the username and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	//storing result
	$stmt->store_result();


    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // now accouth exist variefy the password
        if (password_verify($_POST['password'], $password)) {
            // if varified successfull
            
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            
            header('Location: home.php');
        } else {
            // if password is to be incorrect
            echo 'Incorrect username and/or password!';
        }
    } else {
        // incorrect username or password
        echo 'Incorrect username and/or password!';
    }


	$stmt->close();
}
?>