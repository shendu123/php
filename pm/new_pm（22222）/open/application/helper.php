
<?php
//------------------------
// 助手函数
//-------------------------

/**
 * 对ID加密
 * @param null|int $length
 * @param null|string $salt
 * @param null|string $alphabet
 * @return Hashids\Hashids static
 */
function hashids($length = null, $salt = null, $alphabet = null)
{
    return \Hashids\Hashids::instance($length, $salt, $alphabet);
}

/**
 * 一键导出Excel 2007格式
 * @param array $header     Excel头部 ["COL1","COL2","COL3",...]
 * @param array $body       和头部长度相等字段查询出的数据就可以直接导出
 * @param null|string $name 文件名，不包含扩展名，为空默认为当前时间
 * @param string|int $version 版本 2007|2003|ods|pdf
 * @return string
 */
function export_excel($header, $body, $name = null, $version = '2007')
{
    return \Excel::export($header, $body, $name, $version);
}

/**
 * 获取七牛上传token
 * @return mixed
 */
function qiniu_token()
{
    return \Qiniu::token();
}

/**
 * 文件下载
 * @param $file_path
 * @param string $file_name
 * @param string $file_size
 * @param string $ext
 * @return string
 */
function download($file_path, $file_name = '', $file_size = '', $ext = '')
{
    return \File::download($file_path, $file_name, $file_size, $ext);
}

/**
 * @function curl function
 *
 * @param string $url
 * @param number $post
 * @param string $data
 * @param string $token
 */
function curl_get_content($url,$post=0,$data="",$token="", $return_array = 0){

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
        return $return_array == 1 ? json_decode($err, true) : json_decode($err);
    }else{
        return $return_array == 1 ? json_decode($res, true) : json_decode($res);
    }

}

/**
 * 多个数组的笛卡尔积
*
* @param unknown_type $data
*/
function combineDika() {
    $data = func_get_args();
    $data = current($data);
    $cnt = count($data);
    $result = array();
    $arr1 = array_shift($data);
    foreach($arr1 as $key=>$item) 
    {
        $result[] = array($item);
    }       

    foreach($data as $key=>$item) 
    {                                
        $result = combineArray($result,$item);
    }
    return $result;
}


/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
*/
function combineArray($arr1,$arr2) {         
    $result = array();
    foreach ($arr1 as $item1) 
    {
        foreach ($arr2 as $item2) 
        {
            $temp = $item1;
            $temp[] = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}