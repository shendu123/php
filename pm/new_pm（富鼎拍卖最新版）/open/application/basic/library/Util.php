<?php
namespace app\basic\library;

const PRIVATEKEY = "uiiy&Y7uie32ueyi";
// use Library\Util\Util;
class Util{



	public function tip($type,$tip,$data=null){
	    switch ($type) {
	        case 'I':
	            $retrun['type']='information';
	            break;
	        case 'S':
	        case 'Y':
	            $retrun['type']='success';
	            break;
	        case 'E':
	        case 'N':
	            $retrun['type']='error';
	            break;
	        case 'W':
	            $retrun['type']='warning';
	            break;
	        case 'C':
	            $retrun['type']='confirm';
	            break;
	        default:
	            $retrun['type']=$type;
	            break;
	    }

	    $retrun['tip']=$tip;
	    $retrun['data']=$data;
	    echo json_encode($retrun,JSON_UNESCAPED_UNICODE);
	    exit();
	}

	public function tipB($type,$tip,$data=null){
	    switch ($type) {
	        case 'I':
	            $retrun['type']='information';
	            break;
	        case 'S':
	        case 'Y':
	            $retrun['type']='success';
	            break;
	        case 'E':
	        case 'N':
	            $retrun['type']='error';
	            break;
	        case 'W':
	            $retrun['type']='warning';
	            break;
	        case 'C':
	            $retrun['type']='confirm';
	            break;
	        default:
	            $retrun['type']='success';
	            break;
	    }

	    $retrun['tip']=$tip;
	    $retrun['data']=$data;
	    return $retrun;
	    // echo json_encode($retrun,JSON_UNESCAPED_UNICODE);
	}


	/**
     * [getUID 32位的唯一ID]
     * @return [type] [description]
     */
    public function getUID(){
        date_default_timezone_set('PRC');

        // $units = array();
        // for($i=0;$i<500000;$i++){
        return  $units[]=md5(uniqid(md5(microtime(true)),true));
            // $units[]=date('ymdHis',time()).mt_rand(10000000,99999999);
        // }
        // // var_dump($units);
        // $values  = array_count_values($units);
        // $duplicates = [];
        // foreach($values as $k=>$v){
        //         if($v>1){
        //                 $duplicates[$k]=$v;
        //         }
        // }
        // echo '<pre>';
        // var_dump($duplicates);
        // echo '</pre>';
        // exit;
    }

    /**
	 * [getID 生成20位的id值:系统时间（年月日时分秒）+ 8位随机数]
	 * @return [string] [id]
	 */
	public function getID(){
        date_default_timezone_set('PRC');
		return date('ymdHis',time()).mt_rand(10000000,99999999);
	}


	public function issetData(&$a,$b){
        return isset($a)?$a:$b;
    }



    public function newCurl($accesstoken,$url,$post,$data=""){

        $ch = curl_init();

        $header  = array(
            "accept: application/json",
            "accesstoken: {$accesstoken}"
        );


		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST,$post);
		if($post){
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        

        $res = curl_exec($ch);
        $err = curl_error($ch);
        if($err){
            return json_decode($err);
        }else{
            return json_decode($res);
        }
        curl_close($ch);

        // return mb_convert_encoding($res, 'utf-8', 'GBK,UTF-8,ASCII');

    }

    /**
     * [createSign 签名]
     * @param  string $value [description]
     * @return [type]        [description]
     */
	public function generateSigninfo( $query = array() ){

		if( ! is_array( $query ) ){
			//exit;
		}

		//拼接參數
		$data2 = $this -> jointParam( $query );

		// 签名
		$signature = '';
		// var_dump($data2.'&'.$this->privateKey);

		$signature = md5($data2.'&'.PRIVATEKEY);


		$signature = strtoupper($signature);

		return $signature ;
	}


    //验证签名
    public function checkSign($data,$newsign){
        $resign = $this->generateSigninfo($data);
        if ($resign != $newsign) {
            // 签名不正确
            echo "签名不正确";
            exit;
        }
        return true;
    }



	//拼接參數 用於合成signinfo
	public function jointParam( $query ){
		if ( !$query ) {
			return null;
		}

		//重新组装参数
		$params = '';
		foreach($query as $key => $value){
			$ignore = ['payType','Remark','products'];
			if(!in_array($key,$ignore)){
				if($params==''){
					$params = $key .'='. $value ;
				}else{
					$params = $params.'&'.$key .'='. $value ;
				}
				
			}
			
		}

		// var_dump($params);

		return $params;



	}


	public function checkPostIsempty($po,$need){
		$has = [];
		foreach ($po as $key => $va) {
			$has[] = $key;
		}

		foreach ($need as $key => $va) {
			if(!in_array($va, $has)){
				$this->tip('N',"缺少参数{$va}");
			}
		}

        $t = array_keys(array_map('trim', $po), '');
		if($t) {
            $this->tip('N',"提交参数存在不能有空值",$t);
        }
	}


































}