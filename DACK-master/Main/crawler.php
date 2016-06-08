<link href="style/crawler.css" rel="stylesheet" type="text/css">
<?php 
//Curl.php
ini_set('max_execution_time', 300);
class cURL {
	var $headers;
	var $user_agent;
	var $compression;
	var $cookie_file;
	var $proxy;
	function __construct($cookies=TRUE,$cookie='cookies.txt',$compression='gzip',$proxy='') {
		$this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
		$this->headers[] = 'Connection: Keep-Alive';
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$this->compression=$compression;
		$this->proxy=$proxy;
		$this->cookies=$cookies;
		if ($this->cookies == TRUE) $this->cookie($cookie);
	}
	function cookie($cookie_file) {
		if (file_exists($cookie_file)) {
			$this->cookie_file=$cookie_file;
		} else {
			fopen($cookie_file,'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
			$this->cookie_file=$cookie_file;
			fclose($this->cookie_file);
		}
	}
	function get($url) {
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
		if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
		if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($process,CURLOPT_ENCODING , $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}
	function post($url,$data) {
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
		if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
		if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($process, CURLOPT_ENCODING , $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
		curl_setopt($process, CURLOPT_POSTFIELDS, $data);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($process, CURLOPT_POST, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}
	function error($error) {
		echo "<center><div style='width:500px;border: 3px solid #FFEEFF; padding: 3px; background-color: #FFDDFF;font-family: verdana; font-size: 10px'><b>cURL Error</b><br>$error</div></center>";
		die;
	}

}
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';



$curl = new cURL();

$url = $curl->get ('http://vietnamnet.vn/');
preg_match_all('#/vn/(.*?)"#',$url,$match);
$link = $match;
unset($link[1]);
$lno = count ($link[0]);
$j = 0;
for($i = 0;$i < $lno ; $i++)
{
	if (!preg_match('#/vn/(.*?)html#', $link[0][$i], $matches)||$link[0][$i] == $link[0][$i+1]||preg_match('#/vn/(.*?)index.html#', $link[0][$i], $matches))
		unset($link[0][$i]);
	else 
	{
		$nLink[$j] = 'http://vietnamnet.vn'.rtrim($link[0][$i],'"');
		$j++;
	}
		
}


// $j: số bài báo sẽ craw
// m chỉnh lại cái time out t để nguyên mặc định 120s
$count=0;
date_default_timezone_set('Asia/Ho_Chi_Minh');
for ($i = 0; $i < $j; $i++)
{
	//Begin
	$curl = new cURL();

	$html = $curl->get($nLink[$i]);
	//Biến
	$result = array();
	$header ='#<h1 class="title">(.*?)</h1>#';
	$categories = '#class="Name">(.*?)</a>#';
	$tag = '#class="tagBoxTitle">Tags: (.*?) class="fmsidWidgetNewsBoxAnchor"#';
	$temp = '››' ;
	$temp1 = 'FacebookgoogleBình';
	$head = '24h qua';
	//Html
	preg_match($header,$html,$match);
	$result['Header'] = $match[1];
	preg_match($tag,$html,$match);

	$tags = $result['Tags'] = strip_tags($match[1]);


	preg_match($categories,$html,$match);
	$result['Categories'] = $match[1];

	//String
	$str = strip_tags($html);
	$fline = strpos($str,$temp);
	$lline = strpos($str,$temp1);
	$tline = strpos($str,$tags);
	$post = substr($str,$fline+6,$lline);
	if($tline<$lline - 100)
		$post1 = explode ($temp1, $post);
	else
		$post1 = explode ('Tags: ', $post);
	$post2 = explode ($head, $post1[0]);
	if ( ! isset($post2[1])) {
   		$post2[1] = null;
	}
	$post3 = explode ('FACEBOOK ỨNG DỤNG TUYỂN DỤNG RSS', $post2[1]);
	$result['Date'] = $post3[0];
	if ( ! isset($post3[1])) {
   		$post3[1] = null;
	}
	$post4 = explode ('GMT+7',$post3[1]);
	if ( ! isset($post4[1])) {
   		$post4[1] = null;
	}
	$result['Post'] = $post4[1];
	//lấy comment
	$result['Comment'] = 0;
	$cmd =__DIR__ ."\Debug\ConsoleApplication1.exe \"".$nLink[$i];
	exec($cmd , $output,$s);
	$path = "html.html";
	//$html = (file("html.html"));
	//print_r($html);
	$fp = @fopen($path, "r");
	  
	// Kiểm tra file mở thành công không
	if (!$fp) {
	    echo 'Mở file không thành công';
	}
	else
	{
	    // Đọc file và trả về nội dung
	    $html = fread($fp, filesize($path));
	    preg_match('#data-key="(.*?)"#' , $html, $match);
	    $cmt = '#'.$match[1].'">(.*?)</span>#';
	    if (!preg_match($cmt, $html))
	    {
	    	$result['Comment'] = 0;
	    }
	    else
	    {
		    preg_match($cmt, $html, $comment);
		    $result['Comment'] = $comment[1];
		}

	}
	echo '<pre>';
	print_r ($result);
	$servername = "mysql.hostinger.vn";
	$username = "u194549403_h2";
	$password = '123456';
	$db = "u194549403_bf";
	$mabai=crypt($result['Header']);
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	// Check connection
	mysqli_query($conn,"SET character_set_results=utf8");
	$t=time();
	$t = date ("Y-m-d H:i:s", $t);
	$sql="INSERT INTO raw_info (mabai, tuade, noidung,theloai,ngay, ngaycrawl,dohot,chon)
VALUES ('$mabai',N'$result[Header]', N'$result[Post]', N'$result[Categories]', N'$result[Date]','$t','$result[Comment]','No')";
	if ($conn->query($sql) === TRUE) {
	echo "<p class='congra'>Đã lưu cập nhật<p>";
	$count++;
	} else {
	echo "<p class='error'>Bỏ qua <p>";
	}
}
echo "<h3>Số bài thên vào: <b>".$count."</b><h3>";
?>
