<?php
namespace app\auction\library;

class Util{

	public function curl_get_content($url,$post=0,$data="",$token=""){

		$ch = curl_init();

		$header  = array(
			"accept: application/json",
			"accesstoken: {$token}"
		);


		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST,$post);
		if($post){
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		

		$res = curl_exec($ch);
		// echo $res;
		$err = curl_error($ch);
		curl_close($ch);

		if($err){
			return json_decode($err);
		}else{
			return json_decode($res);
		}

	}
}