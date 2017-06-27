<?php
  
define("APPID", "wxf729cdb722d5185c");
define("APPSECRET", "bce7b9e7340e97038fa884d4b5058648");
  
$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
//echo $res;
$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
$access_token = $result['access_token'];

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $access_token);
fclose($myfile);