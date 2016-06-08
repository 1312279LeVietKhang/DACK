<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<div class="row">

  <div class="col-md-2 col-md-offset-5 success">
    <p>{{message}} {{ currentUser.firstname }}</p>
    <p>Nhấp vào <a href="../../../Main/raw.php">đây</a> để tiếp tục</p>
    <?php
	session_start();
	print "<p>{{ currentUser.firstname }}</p>";
	$_SESSION['id'] = "{{ currentUser.firstname }}";
	$_SESSION['name']="{{ currentUser.firstname }}";
	print "Bạn đã đăng nhập với tài khoản {$_SESSION['name']} thành công.";
	?>
  </div>
</div><!-- meetings cf -->

</body>
</html>