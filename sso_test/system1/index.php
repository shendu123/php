
<?php
    require '../sso/sso.php';
    if(empty($_COOKIE['username'])){
        if(empty($_GET['access_token'])){
            header('location:http://sso.zxl?return_url=http://system1.zxl');
        }else{
            $info = get_info("http://sso.zxl?ac=auth&access_token={$_GET['access_token']}");
            $info = json_decode($info,true);
            if($info['code'] == 1){
                setcookie('username',$info['user']);
            }else{
                exit($info['msg']);
            }

        }
    }

function get_info($url){

    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

    echo '成功登录system1';
?>