<?php
	class wechat_class{
		//获取access_taken，存入服务器缓存文件中
		public function get_access_taken($appid,$appsecret){
			define("APPID", $appid);
			define("APPSECRET", $appsecret);
			
			$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
			$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
			//echo $res;
			$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
			$access_token = $result['access_token'];
			
			$myfile = fopen("access_token.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $access_token);
			fclose($myfile);
		}
		//从缓存文件中读取access_taken
		public function read_access_taken(){
			$file = fopen("access_token.txt","r");
			$str=fread($file,filesize("access_token.txt"));
			fclose($file);
			return $str;
		}
		//
		private function https_request($url,$data){ 
			$curl = curl_init(); 
			curl_setopt($curl, CURLOPT_URL, $url); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
			if (!empty($data)){ 
				curl_setopt($curl, CURLOPT_POST, 1); 
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
			} 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($curl); 
			curl_close($curl); 
			return $output; 
		}
		//设置自定义菜单，成功与否返回json格式的信息
		public function set_menu($access_token,$data){
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token; 
			$result = $this->https_request($url, $data);
			return $result;
		}
		
	}
