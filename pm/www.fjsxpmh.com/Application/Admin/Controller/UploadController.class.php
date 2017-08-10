<?php
namespace Admin\Controller;
use Think\Controller;
class UploadController extends Controller {
    /**
      +----------------------------------------------------------
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
      +----------------------------------------------------------
     */
    public function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        header("Content-Type:text/html; charset=utf-8");
        if (!$_SESSION['my_info']['aid']) {
            E('哎哟！怎么到这里了?');
        }
    }

    //商品图片上传
    Public function upGoodsPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upload();
        echojson($upload);
    }
    //广告图片上传
    Public function upAdvFile () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_uploadAdv();
        echojson($upload);
    }
    //分类图标上传
    Public function upCateIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upCateIco();
        echojson($upload);
    }
    //友链图标上传
    Public function upLinkIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upLinkIco();
        echojson($upload);
    }
    //文章图标上传
    Public function upNewsIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upNewsIco();
        echojson($upload);
    }
    //专场列表图片上传
    Public function upSpecialIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upSpecialIco();
        echojson($upload);
    }
    //专场BANNER图片上传
    Public function upSpecialBnner () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upSpecialBnner();
        echojson($upload);
    }
    //专场列表图片上传
    Public function upMeetingIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upMeetingIco();
        echojson($upload);
    }
    //专场BANNER图片上传
    Public function upMeetingBnner () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upMeetingBnner();
        echojson($upload);
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
    //后台分享链接默认图片
    Public function upSharePic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upSharePic();
        echo json_encode($upload);
    }
    //后台分享链接默认图片
    Public function upCodemapPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upCodemapPic();
        echo json_encode($upload);
    }
    /**
    * 后台分享链接默认图片
    * @return [Array]         [图片上传信息]
    */
    Private function _upCodemapPic () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('WEI_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),//允许上传的文件后缀
            'autoSub' => false,//自动子目录保存文件
        );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($thumbImgUrl);
            $imgThumb->thumb(430,430,\Think\Image::IMAGE_THUMB_CENTER)->save(C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename']);
            $path = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            return array(//返回数据
            'status' => 1,
            'path' => $path,
            'savepath' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    /**
    * 后台分享链接默认图片
    * @return [Array]         [图片上传信息]
    */
    Private function _upSharePic () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('WEI_PICPATH') . '/',//商品图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),//允许上传的文件后缀
            'autoSub' => false,//自动子目录保存文件
        );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadImg = $info['savepath'] . $info['savename'];//上传的图片和路径
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($thumbImgUrl);
            $imgThumb->thumb(C('WEI_LIST_WIDTH'),C('WEI_LIST_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save(C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename']);
            $path = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            return array(//返回数据
            'status' => 1,
            'path' => $path,
            'savepath' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('WEI_TOP_WIDTH') || $cateHeight > C('WEI_TOP_HEIGHT')){
                $imgCate->thumb(C('WEI_TOP_WIDTH'),C('WEI_TOP_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('WEI_LIST_WIDTH') || $cateHeight > C('WEI_LIST_HEIGHT')){
                $imgCate->thumb(C('WEI_LIST_WIDTH'),C('WEI_LIST_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
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
            'exts' => array('jpg', 'gif', 'jpeg'),//允许上传的文件后缀
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

            //生成缩略图
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($cutImgUrl);
            $picFixArr=explode(',', C('GOODS_PIC_PREFIX'));
            // 生成原图等比缩放图片
            $imgThumb->thumb(1920,1080,\Think\Image::IMAGE_THUMB_SCALE)->save(C('UPLOADS_PICPATH').$info['savepath'] . $info['savename']);
            foreach ($picFixArr as $pFixK => $pFixV) {
				$imSizeW = picSize($pFixK,'width');
				$imSizeH = picSize($pFixK,'height');
                $imgThumb->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_FILLED)->save(C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename']);
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
                        'prepath' => picRep($uploadImg,0),
                        'maxpath' => picRep($uploadImg,1),
                        'minipath'=> picRep($uploadImg,3),
                        'msg' => '上传成功并保存到了数据库！'
                        );
                }
            }else{ //否则 是发布商品只上传不保存到数据库
                return array(//返回数据
                    'status' => 1,
                    'path' => $uploadImg,
                    'prepath' => picRep($uploadImg,0),
                    'maxpath' => picRep($uploadImg,1),
                    'minipath'=> picRep($uploadImg,3),
                    'msg' => '上传成功！'
                    );  
            }
            

            
        }
    }
    /**
    * 广告图片上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _uploadAdv () {
        if(I('post.up_type') == '1'){
            $fileExts = array('jpg', 'gif', 'jpeg');// 设置附件上传类型
        }else{
            $fileExts = array('swf');
        }
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('ADV_PICPATH') . '/',//广告图片保存路径
            'saveName' => array('uniqid',''),//保存文件名
            'allowExts' => $fileExts,//允许上传的文件后缀
            'autoSub' => true,//自动子目录保存文件
            'subName' => array('date','Ymd'),//子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        );
        $data = I('post.');
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        $info = $info['file'];
        if(!$info) {// 上传错误提示错误信息        
            return array('status' => 0, 'msg' => $upload->getError());
        }else{// 上传成功 获取上传文件信息
            $uploadFile = $info['savepath'] . $info['savename'];//上传的图片和路径
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //如果大于配置文件配置最大宽度高度进行缩略图处理
            if($data['0']['up_type'] == '1'){
                //缩略图生成
                $imgAdv = new \Think\Image(); 
                $imgAdv->open($cutImgUrl);
                $advWidth = $imgAdv->width(); // 返回图片的宽度
                $advHeight = $imgAdv->height(); // 返回图片的高度
                if($advWidth > C('ADV_MAX_WIDTH') || $advHeight > C('ADV_MAX_HEIGHT')){
                    $imgAdv->thumb(C('ADV_MAX_WIDTH'),C('ADV_MAX_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($cutImgUrl);
                }
            }
            //保存到数据库
            $advId = $data['0']['advId'];//获取到的广告id
            if($advId){ //如果是编辑广告会传过来广告id
                $Advertising = M('Advertising');
                $deladvFile = $Advertising->where(array('id'=>$advId))->getField('code');
                @unlink(C('UPLOADS_PICPATH') . $deladvFile);//删除之前广告文件
                //保存上传的广告图片到数据库
                $data = array(
                    'id' => $advId,
                    'code' => $uploadFile
                    );
                if($Advertising->save($data)){
                    return array(//返回数据
                        'status' => 1,
                        'path' => $uploadFile,
                        'msg' => '上传成功并保存到了数据库！'
                        );
                }
            }else{ //否则 是发布商品只上传不保存到数据库
                return array(//返回数据
                    'status' => 1,
                    'path' => $uploadFile,
                    'msg' => '上传成功！'
                    );  
            }
        }
    }
    
    /**
    * 分类图标上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upCateIco () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('CATE_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('CATE_ICO_WIDTH') || $cateHeight > C('CATE_ICO_HEIGHT')){
                $imgCate->thumb(C('CATE_ICO_WIDTH'),C('CATE_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    /**
    * 分类图标上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upLinkIco () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('LINK_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('LINK_ICO_WIDTH') || $cateHeight > C('LINK_ICO_HEIGHT')){
                $imgCate->thumb(C('LINK_ICO_WIDTH'),C('LINK_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    /**
    * 文章图标上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upNewsIco () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('NEWS_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('NEWS_ICO_WIDTH') || $cateHeight > C('NEWS_ICO_HEIGHT')){
                $imgCate->thumb(C('NEWS_ICO_WIDTH'),C('NEWS_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }

    /**
    * 专场列表图上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upSpecialIco () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('SPECIAL_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('SPECIAL_ICO_WIDTH') || $cateHeight > C('SPECIAL_ICO_HEIGHT')){
                $imgCate->thumb(C('SPECIAL_ICO_WIDTH'),C('SPECIAL_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    /**
    * 专场BANNER图上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upSpecialBnner () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('SPECIAL_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('SPECIAL_BANNER_WIDTH') || $cateHeight > C('SPECIAL_BANNER_HEIGHT')){
                $imgCate->thumb(C('SPECIAL_BANNER_WIDTH'),C('SPECIAL_BANNER_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }

    /**
    * 拍卖会列表图上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upMeetingIco () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('MEETING_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('MEETING_ICO_WIDTH') || $cateHeight > C('MEETING_ICO_HEIGHT')){
                $imgCate->thumb(C('MEETING_ICO_WIDTH'),C('MEETING_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    /**
    * 拍卖会BANNER图上传处理
    * @return [Array]         [图片上传信息]
    */
    Private function _upMeetingBnner () {
        $config = array(
            'maxSize' => 3145728,//上传的文件大小限制 (0-不做限制)
            'rootPath' => C('UPLOADS_PICPATH'),//保存根路径
            'savePath' => C('MEETING_PICPATH') . '/',//商品图片保存路径
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
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            //生成缩略图
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); // 返回图片的宽度
            $cateHeight = $imgCate->height(); // 返回图片的高度
            if($cateWidth > C('MEETING_BANNER_WIDTH') || $cateHeight > C('MEETING_BANNER_HEIGHT')){
                $imgCate->thumb(C('MEETING_BANNER_WIDTH'),C('MEETING_BANNER_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(//返回数据
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }


    //editor上传
    Public function editorUpload () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_editorUpload();
        echojson($upload);
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
}