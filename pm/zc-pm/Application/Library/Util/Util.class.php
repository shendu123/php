<?php

namespace Library\Util;


use Endroid\QrCode\QrCode;

class Util{



	public $salt="7yu8ijhhii#";

    /**
     * [encrypt 加密字符串]
     * @param  [string] $data [要加密的]
     * @param  [type] $key  [加密盐]
     * @return [type]       [加密后的字符串]
     */
	function encrypt($data, $key){  
	    $key    =   md5($key);  
	    $x      =   0;  
	    $len    =   strlen($data);  
	    $l      =   strlen($key);  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if ($x == $l)   
	        {  
	            $x = 0;  
	        }  
	        $char .= $key{$x};  
	        $x++;  
	    }  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);  
	    }  
	    return base64_encode($str);  
	}

    /**
     * [decrypt encrypt解密]
     * @param  [type] $data [description]
     * @param  [type] $key  [description]
     * @return [type]       [description]
     */
	function decrypt($data, $key){  
	    $key = md5($key);  
	    $x = 0;  
	    $data = base64_decode($data);  
	    $len = strlen($data);  
	    $l = strlen($key);  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if ($x == $l)   
	        {  
	            $x = 0;  
	        }  
	        $char .= substr($key, $x, 1);  
	        $x++;  
	    }  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))  
	        {  
	            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));  
	        }  
	        else  
	        {  
	            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));  
	        }  
	    }  
	    return $str;  
	}

    /**
     * [createQRcode 生成 （url指向) 二维码]
     * @param  [type] $url [二维码指向地址]
     * @return [type]      [二维码 图片路径]
     */
	public function createQRcode($url){
		$qrCode = new QrCode();
        $qrCode
            ->setText('http://'.$url)
            ->setSize(300)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
            ->setLabel('www.fjsxpmh.com')
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);

        $path = $this->getPath('Public/qrcode/','qrcode.png');

        $ff = $qrCode->save($path);
        return $path;
  
	}


	/**
     * [a_array_unique 一维数组去重]
     * @param  [type] $array [数组]
     * @return [type]        [0->int(1),...]
     */
    public function a_array_unique($array){
       $out = array();
       foreach ($array as $key=>$value) {
           if (!in_array($value, $out)){
               $out[$key] = $value;
           }
       }
       return array_values($out);
    }


    /**
     * [saveFile 保存文件 并重命名]
     * @param  [type] $updir  [存放目录 如uploads/news]
     * @param  [File object]  $file [上传文件]
     * @return [type]         [重命名文件目录]
     */
    public function saveFile($updir,$file){

        $filename = date('Y-m-d');
        if (!file_exists($updir.$filename)){
            mkdir ($updir.$filename);
        }
        $path = $updir.$filename.'/'.$file->getName();
        // var_dump(strlen($path));
        // var_dump($path);
        // if(strlen($path)>30){
        //     $this->util->tipB('N','您的文件名不能太长');exit();
        // }
        $file->moveTo($path);
        if($file->getName()!=null){
            $ext = strtolower(trim(substr(strrchr($path, '.'), 1)));//获取后缀
            $picid = $this->getID();
            rename( $path, $updir.$filename.'/'.$picid.'.'.$ext);
            $path = $updir.$filename.'/'.$picid.'.'.$ext;
        }

        return $path;
    }

    /**
	 * [getID 生成20位的id值:系统时间（年月日时分秒）+ 8位随机数]
	 * @return [string] [id]
	 */
	public function getID(){
        date_default_timezone_set('PRC');
		return date('ymdHis',time()).mt_rand(10000000,99999999);
	}


    /**
     * [getPath 生成文件路径]
     * @param  [type] $updir [description]
     * @param  [type] $file  [description]
     * @return [type]        [description]
     */
	public function getPath($updir,$file){
		   $filename = date('Y-m-d');
        if (!file_exists($updir.$filename)){
            mkdir ($updir.$filename);
        }
        $path = $updir.$filename.'/'.$file;


        if($file!=null){
            $ext = strtolower(trim(substr(strrchr($path, '.'), 1)));//获取后缀
            $picid = $this->getID();
            rename( $path, $updir.$filename.'/'.$picid.'.'.$ext);
            $path = $updir.$filename.'/'.$picid.'.'.$ext;
        }

        return $path;
	}


    // Function to get the client IP address
    public function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    public function getQiangjingTv($url){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($curl);

        if(curl_errno($curl)){
            return curl_error($curl);
        }
        $res =  curl_exec($curl);
        return $res;
        // return mb_convert_encoding($res, 'utf-8', 'GBK,UTF-8,ASCII');
    }

















































}