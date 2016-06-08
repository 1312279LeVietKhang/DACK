<!doctype html>
<html>
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
<link href="style/raw.css" rel="stylesheet" type="text/css">
</head>
<body>
<?PHP
session_start();
if(!CheckLogin())
{
    RedirectToURL("../Login/angular_registration-master/index.html");
    exit;
}
function CheckLogin()
{     
     if(empty($_SESSION['id']))
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
<a href="index.php"><input type="image" src="image/home.png" /></a>
<a href="check.php"><input type="image" src="image/check.png" /></a>
<a href="logout.php"><input type="image" src="image/log_out.png" /></a>
<h1>Buzz Feed</h1>
<?PHP echo "<h3>Welcome, ".$_SESSION['name']. "!</h3>";?>
  <table width="device-width" align="left" cellpadding="0" cellspacing="0" border="1" bordercolor="#34495e">
    <thead>
      <tr>
        <td width="3%" align="center">STT</td>
        <td width="8%" align="center">Tựa đề</td>
        <td width="74%" align="center">Nội dung</td>
        <td width="4%" align="center">Thể loại</td>
        <td width="5%" align="center">Ngày và giờ</td>
        <td width="3%" align="center">Độ hot</td>
        <td width="3%" align="center">Chọn</td>
      </tr>
    </thead>
    <tbody>
      <?php
        $servername = "localhost";
		$username = "";
		$password = '';
		$db = "test";
		$count=0;
		// Create connection
		$conn = new mysqli($servername, $username, $password,$db);
		// Check connection
		if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		} 
			echo "Connected successfully";
		mysqli_query($conn,"SET character_set_results=utf8");
        $sql = "SELECT * FROM raw_info ORDER BY ngaycrawl DESC, dohot DESC";
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
			echo "<td>".$data['ngay']."</td>";
			echo "<td align='center'>".$data['dohot']."</td>";
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
<footer>
buzzfeedvn.esy.es © 2015
</footer>
</body>
</html>