<?php
namespace app\finance\model;

/**
 * @class 模型共用对外交互 与 goods crowd auction freetrading ...
 * @author ljx
 */
class Interaction
{
    /**
     * @function 解析数据中有关于user_id
     * @author ljx
     */
    public function getUserInfos($dataList = array(), $userIdAlias = 'user_id', $wdata = array()){
        $user_ids = array_column($dataList, $userIdAlias);
        $user_ids = array_filter(array_unique($user_ids));
        $user_ids_string = implode(',', $user_ids);
        $postData = array(
            'inid' => $user_ids_string,
			'keyword' => $wdata['keyword']	
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;

        $returnData = array();
        foreach($memberData as $key => $val){
			if(!isset($val['uid'])){
				continue;
			}
            $returnData[$val['uid']] = $val;
        }
        unset($memberData);

        return $returnData;
    }
    
    /**
     * @function 解析数据中有关于拍卖 auction_id
     * @author ljx
     */
    
    /**
     * @function 解析数据中有关于拍卖 crowd_id
     * @author ljx
     */
    
    /**
     * @function 解析数据中有关于商户 business_id
     * @author ljx
     */

    
    // AND SO FORTH
}
