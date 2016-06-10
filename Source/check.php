<!doctype html>
<html ng-app="myApp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kiểm tra</title>
<style type="text/css">

body {
	background-color: #ecf0f1;
}
body,td,th {
	color: #2c3e50;
}
</style>
	
  <link rel="stylesheet" href="css/bootstrap.min.css">
<link href="style/index.css" rel="stylesheet" type="text/css">
  <!-- Angular -->
  <script src="js/lib/angular/angular.min.js"></script>
  <script src="js/lib/angular/angular-route.min.js"></script>
  <script src="js/lib/angular/angular-animate.min.js"></script>

  <!-- Firebase -->
  <script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>
  <script src="https://cdn.firebase.com/libs/angularfire/1.1.4/angularfire.min.js"></script>

  <script src="js/app.js"></script>
  <script src="js/controllers/registration.js"></script>
  <script src="js/controllers/success.js"></script>
  <script src="js/services/authentication.js"></script>
</head>
<body>
<div ng-show="currentUser" ng-controller="RegistrationController">
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">HOT FEED</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">HOME</a></li>
        <li><a href="logout.php" ng-click="logout()">LOGOUT</a></li>
      </ul>
    </div>
</div>
</div>
<div class="container-fluid bg-grey">
<h3>Kiểm tra bài viết</h3>
<p>&nbsp;</p>
<?PHP
session_start();
if(!CheckLogin())
{
    RedirectToURL("login.php");
    exit;
}

if (!empty($_SESSION['Work']))
{$_SESSION['mabai']="";}
function CheckLogin()
{     
     if(empty($_SESSION['work']))
     {
        return false;
     }
     return true;
}
 function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
?>
 <?php
	// define variables and set to empty values
	$mabaimoi=$mabai =$Err="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	if (empty($_POST["mabai"])) {
	 $Err = "Xin nhập mã bài";
	} else 
	{
	 $mabai = test_input($_POST["mabai"]);
	}
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	$servername = "mysql.hostinger.vn";
	$username = "u965438197_h";
	$password = '123456';
	$db = "u965438197_h";
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	mysqli_query($conn,"SET character_set_results=utf8");
	$sql = "SELECT * FROM raw_info WHERE mabai='$mabai'";
	$query = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($query);
	if ($data['chon']=='Yes')
	echo "<br><span class='error'>Bài viết đã được chọn</span><br>";
	else if ($data['chon']=='No'){
	$sql = "SELECT * FROM raw_info"; 
	$sql="UPDATE raw_info SET chon='Yes' WHERE mabai='$mabai'";
	if ($conn->query($sql) === TRUE) {
    echo "Bài <b>".$data['tuade']."</b> đã được chọn thành công<br>Với độ hot: <b>".$data['dohot']."</b><p class='congra'>Mời bạn viết bài</p>";
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$t=time();
	$author="anonymous";
	$ac="Admin";
	$mabaicu=$data['mabai'];
	$mabaimoi=$t.$ac;
	$t = date ("Y-m-d H:i:s", $t);
	$_SESSION['mabai'] = $mabaimoi;
	echo "<a href='staff.php'><input type='image' src='image/add.png'/></a>";
	} else {
    echo "<br>Lỗi: " . $conn->error;
	}
	
	}
	else if ($data['tuade']=='' && $mabai!="" ){
	echo "<br><span class='error'>Bài viết không tồn tại.</span><br>";
	}
	$conn->close();
?>
  
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="apDiv2">
         Mã bài:<br>
        <input type="text" name="mabai" size="60"><br><br>
        <span class="error">* <?php echo $Err;?></span>
    </div>
	<div class="apDiv1"><input type="image" src="image/check.png" /></div>
<form>

<?php
	// define variables and set to empty values
	$Err="";
	$servername = "mysql.hostinger.vn";
	$username = "u965438197_h";
	$password = '123456';
	$db = "u965438197_h";
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	$sql="SELECT * FROM official_info";
	if ($mabaimoi !="")
	{
	$sql = "INSERT INTO official_info (mabai, mabaicu, tacgia, ngay, dohot)
	VALUES ('$mabaimoi', '$mabaicu','$author', '$t', '$data[dohot]')";
	if ($conn->query($sql) === TRUE) {
    echo "<br>(Nhấp vào để viết bài)";
	} else {
    echo "<br>Lỗi: " . $sql . "<br>" . $conn->error;
	}
	}
	$conn->close();
?>
</div>
<footer class="container-fluid text-center b1 navbar-fixed-bottom">
  <p>buzzfeedvn.esy.es © 2015</p> 
</footer>
</body>

</html>