<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hot Feed</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="style/index.css" rel="stylesheet" type="text/css">
</head>
<body>
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
        <li><a href="raw.php">STAFF</a></li>
        <li><a href="#contact">CONTACT</a></li>
        <li><a href="#about">ABOUT</a></li>
      </ul>
    </div>
</div>


<div class="navbar navbar-inverse navbar-lower" role="navigation">	
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
	</div>
	
	<div class="collapse navbar-collapse">
		
        <ul class="nav navbar-nav">
        <li><a  href="index.php">TỔNG HỢP</a></li>
        <li><a href="congnghe.php">CÔNG NGHỆ</a></li>
        <li><a href="doisong.php">ĐỜI SỐNG</a></li>
        <li><a href="quocte.php">QUỐC TẾ</a></li>
        <li><a href="giaoduc.php">GIÁO DỤC</a></li>
        <li><a href="xahoi.php">XÃ HỘI</a></li>
        <li><a href="thethao.php">THỂ THAO</a></li>
        <li class="active"><a href="thitruong.php">THỊ TRƯỜNG</a></li>
        <li><a href="suckhoe.php">SỨC KHỎE</a></li>
        <li><a href="bandoc.php">BẠN ĐỌC</a></li>
        <li><a href="chinhtri.php">CHÍNH TRỊ</a></li>
        <li><a href="giaitri.php">GIẢI TRÍ</a></li>
        <li><a href="kinhdoanh.php">KINH DOANH</a></li>
        <li><a href="khac.php">KHÁC</a></li>
        </ul>
    </div>
</div>
<div class="container-fluid bg-grey">
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
	mysqli_query($conn,"SET character_set_results=utf8");
	$sql = "SELECT * FROM official_info where theloai=N'Thị trường' ORDER BY  dohot DESC, ngay DESC";
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
<footer class="container-fluid text-center b1 navbar-fixed-bottom">
  <p>buzzfeedvn.esy.es © 2015</p> 
</footer>

</body>


</html>