<?php

namespace app\spider\controller;

use app\spider\common\Spider;
/**
 * Site controller
 */
class Goods extends \think\Controller
{
    public function __construct() {
    }

    //获取父类
    public function actionParent()
    {
        $auto = Yii::$app->request->get('auto');
        $objSpider = new Spider();
        $content = $objSpider->getContent('http://www.ymt.com/gongying_c41');
        $content = $objSpider->getStrByStartEnd($content, '<div class="subnav">', '<div class="content">');
        $pattern = '/href="http:\/\/www.ymt.com:80\/gongying_c(.*)">(.*)<\/a>/i';
        preg_match_all($pattern, $content, $m);
        if ($m) {
            $newArr = array_combine($m[1], $m[2]);
            //数据库操作
            $connection = \Yii::$app->db;
            $count = 1;
            foreach ($newArr as $k => $v) {
                if (!Goods::findOne(['ymt_cat_id' => $k])) {
                    $data = ['ymt_cat_id' => $k, 'cat_name' => $v, 'sort_order' => "{$count}0"];
                    //print_r($data);exit;
                    $connection->createCommand()->insert(Goods::tableName(), $data)->execute();
                    $count++;
                }
            }
            Goods::updateAll(['add_time' => time()], ['cat_pid' => 0, 'add_time' => 0]);
            $count = count($newArr);
            unset($newArr);
            echo "产品父类采集完成，共采集{$count}条数据！";
            if ($auto) {
                echo "<br/>开始采集子类";
                echo "<script>window.location='/category/son?auto=1';</script>";
            }
        }
    }

    //获取子类
    public function actionSon()
    {
        //参数
        $ymt_cat_id = Yii::$app->request->get('ymt_cat_id');
        $auto = Yii::$app->request->get('auto');

        set_time_limit(0);
        $objSpider = new Spider();

        if (!$ymt_cat_id) {
            if ($result = Goods::find()->where("cat_pid='0'")->orderBy('ymt_cat_id')->asArray()->one()) {
                $ymt_cat_id = $result['ymt_cat_id'];
            } else {
                die('未找到分类信息');
            }
        }

        if ($result = Goods::findOne(['ymt_cat_id' => $ymt_cat_id])) {
            $url = "http://www.ymt.com:80/gongying_c{$result['ymt_cat_id']}";
            $content = $objSpider->getContent($url);
            $content = $objSpider->getStrByStartEnd($content, '<ol class="list b-list" id="b_list">', '</ol>');
            $pattern = "/href=\'http:\/\/www.ymt.com:80\/gongying_(.*)'>(.*)<\/a>/i";
            preg_match_all($pattern, $content, $m);
            if ($m) {
                $newArr = array_combine($m[1], $m[2]);
                //数据库操作
                $connection = \Yii::$app->db;
                $count = 1;
                foreach ($newArr as $k => $v) {
                    if (!Goods::findOne(['ymt_cat_id' => $k])) {
                        $data = ['cat_pid' => $result['cat_id'], 'ymt_cat_id' => $k, 'ymt_cat_pid' => $result['ymt_cat_id'], 'cat_name' => $v, 'sort_order' => "{$count}0"];
                        //print_r($data);exit;
                        $connection->createCommand()->insert(Goods::tableName(), $data)->execute();
                        $count++;
                    }
                }
                //修改子类添加时间
                Goods::updateAll(['add_time' => time()], ['cat_pid' => $result['cat_id']]);
            }
            $count = count($newArr);
            unset($newArr);
            echo "{$result['cat_name']}子类采集完成，共采集{$count}条数据<br/>";
            if ($result = Goods::find()->where("ymt_cat_id > {$ymt_cat_id} and cat_pid='0'")->orderBy('ymt_cat_id')->asArray()->one()) {
                $goUrl = "/category/son?ymt_cat_id={$result['ymt_cat_id']}";
                if ($auto) {
                    $goUrl .= "&auto=1";
                }
                echo "<script>window.location='{$goUrl}';</script>";
            } else {
                echo '<br/>子类采集完成！';
                if ($auto) {
                    echo "<br/>开始采集品种";
                    echo "<script>window.location='/category/variety?auto=1';</script>";
                }
            }
        }
    }
     function catch_img(){
            if(!session('goodsData')){
                set_time_limit(0);
                $objSpider = new Spider();
                $content = $objSpider->getContent('http://www.5fengshou.com/sell/mc1_a0_c0_f_p1');
                $content = $objSpider->getStrByStartEnd($content, '<div class="erji-nav">', '<div class="wrapper">');
                $pattern = '/href="\/sell\/mc(.*)_a0_c0_f_p1">(.*)<\/a>/i';   
                preg_match_all($pattern, $content, $m);
                if ($m) {
                   $newArr = array_combine($m[1], $m[2]);//dump($newArr);exit;
                   foreach($newArr as $k=>$v){
                        $content2 = $objSpider->getContent('http://www.5fengshou.com/sell/mc'.$k.'_a0_c0_f_p1');
                        $pattern2 = '/href="\/sell\/mc'.$k.'_a0_c(\d*)_f([A-Z]+)_p1">(.*)<\/a>/i';
                        preg_match_all($pattern2, $content2, $m2);
                        if($m2){//echo "<pre>";print_r($m2);
                               unset($m2[0]);
                               foreach($m2 as $k2=>$v2){
                                   foreach($v2 as $k3=>$v3){
                                              $arr[$k]['pname']=$v;
                                              $arr[$k][$m2[1][$k3]]['url']='http://www.5fengshou.com/sell/mc'.$k.'_a0_c'.$m2[1][$k3].'_f'.$m2[2][$k3].'_p1';
                                              $arr[$k][$m2[1][$k3]]['son_name']=$m2[3][$k3];

                                   }
                               }                     
                        }        
                   }            
                  session('goodsData' , $arr);
            }
         }                               
         $this->redirect('catch_img2');
     }
     
     function catch_img2(){
           set_time_limit(0); 
           $objSpider = new Spider();
           $goods=new \app\spider\model\Goods();
           $goodsDir = './uploads/spiderGoodsImg/';
           //echo "<pre>";print_r(session('goodsData'));exit;
           foreach(session('goodsData') as $k=>$v){
               foreach($v as $k2=>$v2){ 
                   if(!is_array($v2)){
                       continue;
                   }
                    $content3 = $objSpider->getContent($v2['url']);
                    $path=$goodsDir.$v['pname'].'/'.$v2['son_name'].'/';
                    $content3 = $objSpider->getStrByStartEnd($content3, '<div class="wrapper">', '<div class="footer-helpList">');
                    $goods->get_pic($content3,iconv("UTF-8", "GBK", $path)); //iconv防止中文目录乱码
               }
           }
           exit;         
     }
}
