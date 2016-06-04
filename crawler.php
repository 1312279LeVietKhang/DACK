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
	//Source
	$result['Link'] = $nLink[$i];
	//Html
	preg_match($header,$html,$match);
	$result['Header'] = $match[1];
	preg_match($tag,$html,$match);
	$tags = $result['Tags'] = strip_tags($match[1]);
	preg_match($categories,$html,$match);
	$result['Categories'] = $match[1];
	//String
	$str = strip_tags($html);
	$gmt = explode('GMT+7',$str);
	$date = explode($result['Header'],$gmt[1]);
	$result['Time'] = $date[1];
	$post = explode('Tags', $gmt[2]);
	$result['Post'] = $post[0];
	echo '<pre>';
	print_r ($result);
}
?>
