<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {
    //商品图片上传
    Public function upUserPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upUserPic();
        echojson($upload);
    }
    //商品图片上传
    Public function upGoodsPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upload();
        echojson($upload);
    }
    //editor上传
    Public function editorUpload () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_editorUpload();
        echojson($upload);
    }
    //editor上传
    Public function weiUploadTool () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_weiUploadTool();
        echojson($upload);
    }
    // 微信浏览器内图片上传
    public function _weiUploadTool(){
        $serverid = I('post.serverid');
        $serverids = explode(',', $serverid);
        // 获取access_token
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.C('Weixin.appid').'&secret='.C('Weixin.appsecret');
        $data=file_get_contents($url);
        $data = json_decode($data);
        $openid = $data->openid;
        $access_token = $data->access_token;
        S('test1',$serverids);
        $imgnames=array();
        foreach ($serverids as $key => $value) {
            $content = file_get_contents('https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$value);
            $savename = uniqid().'.jpg';
            switch (I('post.uptype')) {
                case 'goods':
                    $cutImgUrl = C('UPLOADS_PICPATH').C('GOODS_PICPATH').'/'.date('Ymd',time()).'/'. $savename;
                    $savepath = C('GOODS_PICPATH').'/'.date('Ymd',time()).'/';
                    if (!is_dir(C('UPLOADS_PICPATH').$savepath)) mkdir(C('UPLOADS_PICPATH').$savepath, 0777); // 使用最大权限0777创建文件
                    if (!file_exists($cutImgUrl)) { // 如果不存在则创建
                        // 检测是否有权限操作
                        if (!is_writeable($cutImgUrl)) chmod($cutImgUrl, 0777); // 如果无权限，则修改为0777最大权限
                        // 最终将d写入文件即可
                        file_put_contents($cutImgUrl,  $content);
                    }
                    $imgnames[$key] =  $this->_goodsDispose($savepath,$savename,$cutImgUrl);              
                    break;
                case 'weitoppic':
                    $cutImgUrl = C('UPLOADS_PICPATH').C('WEI_PICPATH').'/'.date('Ymd',time()).'/'. $savename;
                    $savepath = C('WEI_PICPATH').'/'.date('Ymd',time()).'/';
                    if (!is_dir(C('UPLOADS_PICPATH').$savepath)) mkdir(C('UPLOADS_PICPATH').$savepath, 0777); // 使用最大权限0777创建文件
                    if (!file_exists($cutImgUrl)) { // 如果不存在则创建
                        // 检测是否有权限操作
                        if (!is_writeable($cutImgUrl)) chmod($cutImgUrl, 0777); // 如果无权限，则修改为0777最大权限
                        // 最终将d写入文件即可
                        file_put_contents($cutImgUrl,  $content);
                    }
                    $imgnames[$key] =  $this->_weitopDispose($savepath,$savename,$cutImgUrl);              
                    break;
                case 'weilistpic':
                    $cutImgUrl = C('UPLOADS_PICPATH').C('WEI_PICPATH').'/'.date('Ymd',time()).'/'. $savename;
                    $savepath = C('WEI_PICPATH').'/'.date('Ymd',time()).'/';
                    if (!is_dir(C('UPLOADS_PICPATH').$savepath)) mkdir(C('UPLOADS_PICPATH').$savepath, 0777); // 使用最大权限0777创建文件
                    if (!file_exists($cutImgUrl)) { // 如果不存在则创建
                        // 检测是否有权限操作
                        if (!is_writeable($cutImgUrl)) chmod($cutImgUrl, 0777); // 如果无权限，则修改为0777最大权限
                        // 最终将d写入文件即可
                        file_put_contents($cutImgUrl,  $content);
                    }
                    $imgnames[$key] =  $this->_weilistDispose($savepath,$savename,$cutImgUrl);              
                    break;
            }
        }
        return $imgnames;
    }




    /**
    * uEditor图片上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _editorUpload () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('ARTICLE_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'jpeg'),//允许上传的文件后缀
            'autoSub' => true,//自动子目录保存文件
            'subName' => array('date','Ymd'),//子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        );
        
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['upfile'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            return array(
                'url'      =>$info['savepath'] . $info['savename'],   //保存后的文件路径
                'title'    => htmlspecialchars($_POST['pictitle'], ENT_QUOTES),   //文件描述，对图片来说在前端会添加到title属性上
                'original' => $info['name'],   //原始文件名
                'state'    =>'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
            );
        }
    }
    /**
     * 商品图片上传处理
     * @return [Array]         [图片上传信息]
     */
    Private function _upload () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('GOODS_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'jpeg','aae'),//允许上传的文件后缀
            'autoSub' => true,//自动子目录保存文件
            'subName' => array('date','Ymd'),//子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['file'];

        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            return $this->_goodsDispose($info['savepath'],$info['savename'],$cutImgUrl);
        }
    }
    // 商品图片处理操作
    Public function _goodsDispose ($savepath,$savename,$cutImgUrl){
        //生成缩略图
            $uploadImg = $savepath.$savename;
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($cutImgUrl);
            $picFixArr=explode(',', C('GOODS_PIC_PREFIX'));
            // 生成原图等比缩放图片
            $imgThumb->thumb(1920,1080,\Think\Image::IMAGE_THUMB_SCALE)->save($cutImgUrl);
            foreach ($picFixArr as $pFixK => $pFixV) {
                $imSizeW = picSize($pFixK,'width');
                $imSizeH = picSize($pFixK,'height');
                $imgThumb->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_CENTER)->save(C('UPLOADS_PICPATH').$savepath . $pFixV . $savename);

            }
            //保存到数据库
            $goodsId = I('post.goodsId');//获取到的商品id
            if($goodsId){ //如果是编辑商品会传过来商品id
                //读取该商品图片字段，并组合新上传的图片
                $goods = M('Goods');
                $gdPic = $goods->where(array('id'=>$goodsId))->getField('pictures');
                $newPicStr = trim($gdPic.'|'.$uploadImg,'|');

                //保存上传的图片到数据库
                $data = array(
                    'id' => $goodsId,
                    'pictures' => $newPicStr
                    );
                if($goods->save($data)){
                    return array(//返回数据
                        'status' => 1,
                        'path' => $uploadImg,
                        'showimg' => C('UPLOADS_PICPATH').picRep($uploadImg,1),
                        'showurl'=>getImgUrl($uploadImg),
                        'msg' => '上传成功并保存到了数据库！'
                        );
                }
            }else{ //否则 是发布商品只上传不保存到数据库
                return array(//返回数据
                    'status' => 1,
                    'path' => $uploadImg,
                    'showimg' => C('UPLOADS_PICPATH').picRep($uploadImg,1),
                    'showurl'=>getImgUrl($uploadImg),
                    'msg' => '上传成功！'
                    );  
            }
    }


    Public function _weitopDispose ($savepath,$savename,$cutImgUrl){
        //生成缩略图
        $uploadImg = $savepath.$savename;
        $imgCate = new \Think\Image(); 
        $imgCate->open($cutImgUrl);
        $cateWidth = $imgCate->width(); // 返回图片的宽度
        $cateHeight = $imgCate->height(); // 返回图片的高度
        if($cateWidth > C('WEI_TOP_WIDTH') || $cateHeight > C('WEI_TOP_HEIGHT')){
            $imgCate->thumb(C('WEI_TOP_WIDTH'),C('WEI_TOP_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($cutImgUrl);
        }
        return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'showimg'=>C('UPLOADS_PICPATH').$uploadImg,
            'showurl'=>getImgUrl($uploadImg),
            'msg' => '上传成功！'
        );   
    }
    Public function _weilistDispose ($savepath,$savename,$cutImgUrl){
        //生成缩略图
        $uploadImg = $savepath.$savename;
        $imgCate = new \Think\Image(); 
        $imgCate->open($cutImgUrl);
        $cateWidth = $imgCate->width(); // 返回图片的宽度
        $cateHeight = $imgCate->height(); // 返回图片的高度
        if($cateWidth > C('WEI_LIST_WIDTH') || $cateHeight > C('WEI_LIST_HEIGHT')){
            $imgCate->thumb(C('WEI_LIST_WIDTH'),C('WEI_LIST_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($cutImgUrl);
        }
        return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'showimg'=>C('UPLOADS_PICPATH').$uploadImg,
            'showurl'=>getImgUrl($uploadImg),
            'msg' => '上传成功！'
        );   
    }



    //微信头条图片上传
    Public function upWeiTopPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upWeiTopPic();
        echojson($upload);
    }
    //微信列表图片上传
    Public function upWeiListPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upWeiListPic();
        echojson($upload);
    }
    /**
    * 微信头条图片上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upWeiTopPic () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('WEI_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'jpeg'),//允许上传的文件后缀
            'autoSub' => false,//自动子目录保存文件
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['file'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            return $this->_weitopDispose($info['savepath'],$info['savename'],$cutImgUrl);
        }
    }
    /**
    * 微列表条图片上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upWeiListPic() {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('WEI_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'jpeg'),//允许上传的文件后缀
            'autoSub' => false,//自动子目录保存文件
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['file'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            return $this->_weilistDispose($info['savepath'],$info['savename'],$cutImgUrl);
        }
    }
        /**
    * 用户头像上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upUserPic () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('USER_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),//允许上传的文件后缀
            'autoSub' => false,//自动子目录保存文件
        );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['file'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($thumbImgUrl);
            $picFixArr=explode(',', C('USER_PIC_PREFIX'));
            foreach ($picFixArr as $pFixK => $pFixV) {
                $imSizeW = picSize($pFixK,'width','user');
                $imSizeH = picSize($pFixK,'height','user');
                $imgThumb->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_CENTER)->save(C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename']);
                $path[]=C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename'];

            }
            return array(//返回数据
            'status' => 1,
            'path' => $path,
            'savepath' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
}