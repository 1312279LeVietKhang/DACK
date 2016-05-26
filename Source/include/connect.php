<?php
	$servername = "mysql.hostinger.vn";
	$username = "u194549403_h2";
	$password = '123456';
	$db = "u194549403_bf";
	$conn = new mysqli($servername, $username, $password,$db);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>