<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use think\Request;
use think\Db;

use app\finance\model\AuctionOrder;
use app\finance\model\CrowdOrder;
use app\finance\model\FreetradingOrder;

class OrderInfo extends NoAuth
{
	/**
     * @function 会员列表交易记录详情
     * @author zsq
     */
    public function getOrderStatus()
    {
        $oid  = $this->request->get("oid");
        $from = $this->request->get("from");
        $res = [];
        switch ($from) {
            //拍卖
            case 1:
                $model = new AuctionOrder();
                $res = $model->getOrderStatus($oid, $from);
                break;
            //申购
            case 2:
                $model = new CrowdOrder();
                $res = $model->getOrderStatus($oid, $from);
                break;
            //自由买卖
            case 3:
                $model = new FreetradingOrder();
                $res = $model->getOrderStatus($oid, $from);
                
                // $res = $this->getOrderInfoByOid($oid);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
}