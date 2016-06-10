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
{
    RedirectToURL("angularLogin.html");
    exit;
}
else
    echo "KO thể thoát dc, có lỗi trong việc hủy session";
function RedirectToURL($url)
	{
		header("Location: $url");
		exit;
    }

?>
</body>
</html>