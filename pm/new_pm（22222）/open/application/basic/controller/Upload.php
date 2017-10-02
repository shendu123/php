<?php
namespace app\basic\controller;

use app\common\controller\NoAuth;
use think\Request;

class Upload {

    /**
     * [saveFile 保存文件 并重命名]
     * @param  [type] $updir  [存放目录 如uploads/news]
     * @param  [File object]  $file [上传文件]
     * @return [type]         [重命名文件目录]
     */
    public function saveFile($updir,$file){

        $filename = date('Y-m-d');
        // if (!file_exists($updir.$filename)){
        //     mkdir ($updir.$filename);
        // }
        $path = $updir;

        $info  = $file->move($path);

        if($info->getSaveName()!=null){
            $name = $info->getSaveName();

            $path = $updir.$name;
        }

        return $path;
    }


    public function up_file(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = Request::instance()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }


    /**
     * [uploadExcelAction 上传图片]
     * @DateTime 2016-05-26T16:46:35+0800
     * @author   jzbis@sina.com
     * @return   [type]                   [description]
     */
    public function upFile(){
        $type = $_POST['type'];
        $file = Request::instance()->file('upfile');
        // var_dump($type);
        // var_dump($file);exit();
        if ($file) {

            // $this->checkUpfile($file);
            switch ($type) {
                case 'pic':
                    $filepath = $this->saveFile('uploads/pic/',$file);
                break;
                case 'file':
                    $filepath = $this->saveFile('uploads/file/',$file);
                break;
                default:
                    return $this->_error('没有制定上传类型,请post type',500);
                break;
            }
            return ['type'=>"success",'path'=>$filepath];


        }else{
            return ['type'=>"error",'tip'=>'请选择正确的文件'];
        }


    }

    /**
     * [checkUpfile 检查文件]
     * @DateTime 2016-05-26T16:46:52+0800
     * @author   jzbis@sina.com
     * @param    [type]                   $file [description]
     * @return   [type]                         [description]
     */
    public function checkUpfile($file){
        $max_size="2000000";
        $fname=$file->getName();
        $ftype=$file->getType();
        $fsize=$file->getSize();
        if($ftype!='application/vnd.ms-excel'){
            echo'建议使用.xls文件';exit();
        }

        if($file->getSize()>$max_size){
           echo '文件太大了';exit();
        }

    }







}