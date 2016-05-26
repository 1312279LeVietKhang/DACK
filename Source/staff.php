<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Post bài</title>
<link href="style/staff.css" rel="stylesheet" type="text/css">
</head>

<body>
<a href="index.php"><input type="image" src="image/home.png" /></a>
<a href="logout.php"><input type="image" src="image/log_out.png" /></a>
<a href="check.php"><input type="image" src="image/check.png" /></a>
<h3>Hãy viết theo cách của bạn</h3>

<?php
	session_start();
	if(CheckLogin()==1)
	{
		RedirectToURL("login.php");
		exit;
	}
	if(CheckLogin()==2)
	{
		RedirectToURL("check.php");
		exit;
	}
	function CheckLogin()
	{      
		 if(empty($_SESSION['id']))
		 {
			return 1;
		 }
		 if(!empty($_SESSION['id']) && empty($_SESSION['mabai']))
		 {
			return 2;
		 }
		 return 3;
	}
	function RedirectToURL($url)
	{
		header("Location: $url");
		exit;
    }
	$mabai=$_SESSION['mabai'];
	echo "Mã bài mới: <b>".$mabai."</b><br>";
	$tenbai=$noidung=$theloai=$thoigian="";
	$required = array('ten', 'noidung', 'gender');
	$error = false;
	foreach($required as $field) {
	  if (empty($_POST[$field])) {
		$error = true;
	  }
	}
	$servername = "mysql.hostinger.vn";
	$username = "u194549403_h2";
	$password = '123456';
	$db = "u194549403_bf";
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	mysqli_query($conn,"SET character_set_results=utf8");
	$sql = "SELECT * FROM official_info ";
	if ($error) {
	  echo "<p class='error'>Xin điền đầy đủ thông tin<p>";
	} else {
		$tenbai=test_input($_POST["ten"]);
	  	$noidung = test_input($_POST["noidung"]);
	  	$theloai=test_input($_POST["gender"]);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$thoigian=date('Y-m-d H:i:s');
		$sql="UPDATE official_info SET tuade=N'$tenbai', noidung=N'$noidung', theloai=N'$theloai', ngay='$thoigian' where mabai='$mabai'";
		if ($conn->query($sql) === TRUE) {
		echo "<p class='congra'>Đã lưu cập nhật<p>";
		} else {
		echo "<p class='error'>Lỗi: <p>" . $conn->error;
	}
	}
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	$conn->close();
?>
  
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Tên bài mới:<br>
    <input type="text" name="ten" size="60"><br><br>
    Nội dung:<br>
    <textarea name="noidung" rows="20"></textarea>
    Thể loại:
    <input type="radio" name="gender" value="Thể thao">Thể thao
    <input type="radio" name="gender" value="Xã hội">Xã hội
    <input type="radio" name="gender" value="Chính trị">Chính trị
    <input type="radio" name="gender" value="Giáo duc">Giáo dục
    <input type="radio" name="gender" value="Công nghệ">Công nghệ
    <input type="radio" name="gender" value="Đời sống">Đời sống
    <input type="radio" name="gender" value="Quốc tế">Quốc tế
    <input type="radio" name="gender" value="Thị trường">Thị trường
    <input type="radio" name="gender" value="Sức khỏe">Sức khỏe
    <input type="radio" name="gender" value="Bạn đọc">Bạn đọc
    <input type="radio" name="gender" value="Giải trí">Giải trí
    <input type="radio" name="gender" value="Kinh doanh">Kinh doanh
    <input type="radio" name="gender" value="Khác">Khác
    <div class="apDiv1"><input type="image" src="image/save.png" /></div>
<form>
</body>
</html>