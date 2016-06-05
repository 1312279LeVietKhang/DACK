<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	 <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body id="body-color">
<?php
if(isset($_POST['submit'])){
	$errors = array();
	$required = array('email','password');
	foreach ($required as $fieldname) {
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
			$errors[] = "the <strong> {$fieldname} </strong> was left blank.";
		}
	}		
		if(empty($errors)){
			$conn = mysqli_connect('localhost','root','') or die('Could not connect to Database');
			$email = mysqli_real_escape_string($conn, $_POST[email]);
			$password = mysqli_real_escape_string($conn, $_POST[password]);
			$hash_pw = sha1($password);

			$query = "SELECT CONCAT_WS('  ',first_name, last_name)
					  AS name
					  FROM user
					  WHERE email = '{$email}'
					  AND password = '{$hash_pw}'
					  LIMIT 1
					  ";
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
			if(mysqli_num_rows($result) == 1){
				while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					header('Location: admin.php');
				} 
			}else{
					$errors[] = "The email or password do not match those on file!!!";
			}
		}
}
?>
	<div id="Sign-In">
	<?php 
		if(!empty($errors)){
			echo "<ul>";
			foreach ($errors as $errors) {
				echo "<li> $errors </li>";
			}
			echo "</ul";
		}
	?>
		<fieldset style="width:30%" ><legend>LOG-IN HERE</legend>
		<form action="" method="POST"> Email <br>
			<input type="text" name="email" size="40"><br> Password <br>	
			<input type="password" name="password" size="40"><br>
			<input id="button" type="submit" name="submit" value="Đăng Nhập">
		</form>
		<div class="login">
			<a href="#">Login</a>
		</div>
	</div>
</body>
</html>