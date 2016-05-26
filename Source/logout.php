<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thoát</title>
<style type="text/css">
body,td,th {
	font-family: "Times New Roman";
	left: auto;
	color: #e74c3c;
}
body {
	background-color: #e7e7e7;
}
</style>
</head>
<body>
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
echo '<title>Thoát</title>';
if (session_destroy()) 
    echo "Thoát thành công!";
else
    echo "KO thể thoát dc, có lỗi trong việc hủy session";
 
echo '<br><a href="index.php">Bấm vào đây để quay lại trang chủ<br></a>';
?>
</body>
</html>