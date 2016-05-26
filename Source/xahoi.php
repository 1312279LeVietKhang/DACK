<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BuzzfeedVn</title>
<link href="style/index.css" rel="stylesheet" type="text/css">
</head>
<body class="body">
<div class="apDiv2"><a href="index.php"><img src="image/logo.svg" style="width:100%;height:100%;"></a></div>
<ul>
    <li><a href="raw.php">Staff</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#about">About</a></li>
</ul>

<ul2>
    <li2><a href="index.php">TỔNG HỢP</a></li2>
    <li2><a href="congnghe.php">CÔNG NGHỆ</a></li2>
    <li2><a href="doisong.php">ĐỜI SỐNG</a></li2>
    <li2><a href="quocte.php">QUỐC TẾ</a></li2>
    <li2><a href="giaoduc.php">GIÁO DỤC</a></li2>
    <li2><a class="active" href="xahoi.php">XÃ HỘI</a></li2>
    <li2><a href="thethao.php">THỂ THAO</a></li2>
    <li2><a href="thitruong.php">THỊ TRƯỜNG</a></li2>
    <li2><a href="suckhoe.php">SỨC KHỎE</a></li2>
    <li2><a href="bandoc.php">BẠN ĐỌC</a></li2>
    <li2><a href="chinhtri.php">CHÍNH TRỊ</a></li2>
    <li2><a href="giaitri.php">GIẢI TRÍ</a></li2>
    <li2><a href="kinhdoanh.php">KINH DOANH</a></li2>
    <li2><a href="khac.php">KHÁC</a></li2>
</ul2>
<?php
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<div class="apDiv1">
<?php
	$servername = "mysql.hostinger.vn";
	$username = "u194549403_h2";
	$password = '123456';
	$db = "u194549403_bf";
	$count=0;
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	mysqli_query($conn,"SET character_set_results=utf8");
	$sql = "SELECT * FROM official_info where theloai=N'Xã hội' ORDER BY  dohot DESC, ngay DESC";
	$query = mysqli_query($conn,$sql);
	$total = $query->num_rows;
	if($total > 200)
	$total=200;
	for ($x = 0; $x < $total; $x++){
		$data = mysqli_fetch_assoc($query);
		if ($data['tuade']!="")
		{
			$count++;
			echo "<h2 style='color:#e74c3c;'>".$data['tuade']."</h2>";
			$string = strip_tags($data['noidung']);
			echo $data['noidung']."<br>";
			echo "<p style='color:#34495e'><img src='image/man.svg' style='width:10px;height:10px;'> ".$data['tacgia'];
			echo " <img src='image/clock.svg' style='width:10px;height:10px;'> ";
			echo time_elapsed_string($data['ngay']);
			echo "</p>";
			echo "<hr>";
		}
	}
?>

</div>
</body>
<footer class="footer"><p align="center">buzzfeedvn.esy.es © 2015</p></footer>
</html>