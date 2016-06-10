<!doctype html>
<html ng-app="myApp">
<head>
<meta charset="utf-8">
<title>Thông tin thô</title>
<meta name="jujj" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
body,td,th {
	font-family: "Times New Roman";
	left: auto;
	color: #2c3e50;
}
body {
	background-color: #ecf0f1;
}
</style>
<!-- CSS -->
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
<?PHP
session_start();
if(!CheckLogin())
{
    RedirectToURL("angularLogin.html");
    exit;
}
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
        <li><a href="check.php">CHECK</a></li>
        <li><a href="logout.php" ng-click="logout()">LOGOUT</a></li>
      </ul>
    </div>
</div>
</div>
<div class="container-fluid bg-grey">
<h1>Buzz Feed</h1>
<?PHP echo "<h3>Welcome!</h3>";?>
  <table width="device-width" align="left" cellpadding="0" cellspacing="0" border="1" bordercolor="#34495e">
    <thead>
      <tr>
        <td width="3%" align="center">STT</td>
        <td width="8%" align="center">Tựa đề</td>
        <td width="77%" align="center">Nội dung</td>
        <td width="4%" align="center">Thể loại</td>
        <td width="5%" align="center">Ngày và giờ</td>
        <td width="3%" align="center">Chọn</td>
      </tr>
    </thead>
    <tbody>
      <?php
        $servername = "mysql.hostinger.vn";
	$username = "u965438197_h";
	$password = '123456';
	$db = "u965438197_h";
		$count=0;
		// Create connection
		$conn = new mysqli($servername, $username, $password,$db);
		// Check connection
		if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		} 
			echo "Connected successfully";
		mysqli_query($conn,"SET character_set_results=utf8");
        $sql = "SELECT * FROM raw_info ORDER BY ngaycrawl DESC";
        $query = mysqli_query($conn,$sql);
        $total = $query->num_rows;
        if($total > 200)
		$total=200;
		for ($x = 0; $x < $total; $x++){
			$data = mysqli_fetch_assoc($query);
			$count++;
			echo "<tr>";
			 echo "<td align='center'>".$count."</td>";
			echo "<td>".$data['tuade']."<p style='color:red'>Mã bài: </p>".$data['mabai']."</td>";
			echo "<td>".$data['noidung']."</td>";
			echo "<td align='center'>".$data['theloai']."</td>";
			echo "<td align='center'>".$data['ngaycrawl']."</td>";
			if ($data['chon']=='No')
			echo "<td align='center'>".$data['chon']."</td>";
			else
			echo "<td align='center' style='color:red'>".$data['chon']."</td>";
			echo "</tr>";
		}
		?>
                <tr>
                    </td>
                </tr>
	</tbody>
  </table>
</div>

<footer class="container-fluid text-center b1">
  <p>buzzfeedvn.esy.es © 2015</p> 
</footer>
</body>
</html>