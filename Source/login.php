<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng Nhập</title>
<link href="style/login.css" rel="stylesheet" type="text/css">
</head>
<body class="body">
<div class="apDiv2"><a href="index.php"><img src="image/logo.svg" style="width:100%;height:100%;"></a></div>
<ul>
	<li><a class="active" href="staff.php">Staff</a></li>
  	<li><a href="#contact">Contact</a></li>
    <li><a href="#about">About</a></li>
</ul>

<footer class="footer"><p align="center">buzzfeedvn.esy.es © 2015</p></footer>
<?php
session_start();
// Tải file mysql.php lên
require_once("./include/connect.php");
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // Dùng hàm addslashes() để tránh SQL injection, dùng hàm md5() để mã hóa password
    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    // Lấy thông tin của username đã nhập trong table members
    $sql="SELECT id, name, password FROM members WHERE id='$username'";
	$query = mysqli_query($conn,$sql);
	$total = $query->num_rows;
    $member = $data = mysqli_fetch_array($query);
    // Nếu username này không tồn tại thì....
    if ( $total <= 0 )
    {
        print "<p style='text-align:center; color:#e74c3c'>Tên truy nhập không tồn tại</p><p class='link'><a href='javascript:history.go(-1)'>Quay về</a></p>";
        exit;
    }
    // Nếu username này tồn tại thì tiếp tục kiểm tra mật khẩu
    if ( $password != $member['password'] )
    {
        print "<p style='text-align:center; color:#e74c3c'>Nhập sai mật khẩu</p><p class='link'><a href='javascript:history.go(-1)'>Quay về</a></p>";
        exit;
    }
    // Khởi động phiên làm việc (session)
    $_SESSION['id'] = $member['id'];
	$_SESSION['name']=$member['name'];
    // Thông báo đăng nhập thành công
    print "Bạn đã đăng nhập với tài khoản {$member['id']} thành công. <a href='check.php'>Nhấp vào đây để vào trang chủ</a>";
	header("Location: raw.php");
    exit;
}
$conn->close();
?>
<div id="Sign-In">
    <fieldset style="color:#3498db"><legend>ĐĂNG NHẬP</legend>
        <form style="color:#ecf0f1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Tên truy nhập:
            <br> <input type="text" name="username" value=""><br><br>
            Mật khẩu:
            <br> <input type="password" name="password" value="">
            <div class="apDiv1"><input type="image" src="image/log_in.png" /></div>
        </form>
    </fieldset>
</div>
</body>
</html>