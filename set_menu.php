<?php
	include("class/wechat_class.php");
	$obj=new wechat_class();
	
	$appid="wxf729cdb722d5185c";
	$appsecret="bce7b9e7340e97038fa884d4b5058648";
//	$obj->get_access_taken($appid, $appsecret);

	$access_token=$obj->read_access_taken();
	//echo $access_token;
	
	$jsonmenu='
	{ 
	  "button":[ 
			  { 
				  "name":"世优", 
				  "sub_button":[ 
						  { 
						    "type":"view", 
						    "name":"北京天气", 
						    "url":"http://fuzhuoxing.xyz/wechat/login.html"
						   }, 
						   { 
						    "type":"view", 
						    "name":"上海天气", 
						    "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf729cdb722d5185c&redirect_uri=http%3A%2F%2Ffuzhuoxing.xyz%2Fwechat%2Flogin.html&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"
						   }, 
						   { 
						    "type":"click", 
						    "name":"广州天气", 
						    "key":"天气广州"
						   }, 
						   { 
						    "type":"click", 
						    "name":"深圳天气", 
						    "key":"天气深圳"
						   }, 
						   { 
						    "type":"view", 
						    "name":"本地天气", 
						    "url":"http://m.hao123.com/a/tianqi"
						   }
					] 
			  },
			   
			  { 
			   "name":"电力", 
			   		"sub_button":[ 
							   { 
							    "type":"click", 
							    "name":"公司简介", 
							    "key":"company"
							   }, 
							   { 
							    "type":"click", 
							    "name":"趣味游戏", 
							    "key":"游戏"
							   }, 
							   { 
							    "type":"click", 
							    "name":"讲个笑话", 
							    "key":"笑话"
							   }
			   		] 
			  }
	  ] 
	}
	';
	
	$result=$obj->set_menu($access_token, $jsonmenu);
	$arr=json_decode($result,true);
	//print_r($arr['errcode']);
	
	//如果故障码等于42001，即access_taken失效，刷新access_taken，重新读取，重新操作
	if($arr['errcode']=="42001"){
		$obj->get_access_taken($appid, $appsecret);
		$access_token=$obj->read_access_taken();
		$result=$obj->set_menu($access_token, $jsonmenu);
	};
	
	echo $result;