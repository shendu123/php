<?php

namespace console\controllers;

use common\models\simple_html_dom;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleSpiderController extends Controller
{
    function actionGetCon($keyword = '', $limit='', $add = false){

        //$url = 'https://www.cnblogs.com/pick/';
        $url = 'https://news.cnblogs.com/n/digg';
        $content = $this->getContentByUrl($url);
        $html = new simple_html_dom($content);
        foreach($html->find('#news_list .content') as $con){
            $data['title'] = $con->find('.news_entry a',0)->plaintext;
            $data['desc'] = trim($con->find('.entry_summary',0)->plaintext);
            $data['author'] = trim($con->find('.entry_footer a',0)->plaintext);
            $table_keys = array_keys($data);
            $list[] = $data;
        }

        if($keyword){
            $new_list = [];
            foreach($list as $k=>$v){
                if(strpos($v['title'], $keyword) !== false){
                    $new_list[] = $v;
                }
            }
            unset($list);
            $list = $new_list;
        }
        if($limit){
            $list = array_slice($list,0,$limit);
        }
        if($add){
            $this->add($table_keys, $list);
        }else{
            p($list);
        }

        //p($list);
    }

    function add($table_keys, $list){
        Yii::$app->db->createCommand()->truncateTable('article')->execute();
        if(Yii::$app->db->createCommand()->batchInsert('article', $table_keys, $list)->execute()){
            exit('数据插入成功');
        }
    }

    function getContentByUrl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }


}
