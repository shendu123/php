<?php
namespace app\basic\model;

use think\Model;
use think\Db;

/**
 * @class 钱包模型
 * @author ljx
 */
class Wallet extends Model
{

    protected $table = 'op_finance.opf_wallet';

    public $_tableFields = array(
        'wallet_id' => 'int', // 钱包id
        'user_id' => 'int', // 用户id
        'wallet_available_price' => 'int', // 【单位分】可用余额
        'wallet_freeze_price' => 'int', // 【单位分】已冻结余额
        'wallet_integral' => 'int', // 账户积分
        'wallet_checktoken' => 'varchar', // 【预留】三个price组合+salt 生成token 当验证不符合时，冻结账户，进行人工对账审核
        'wallet_intime' => 'int', // 新增时间
        'wallet_uptime' => 'int' /*更新时间**/
	);


    /**
     * @function 新增
     *
     * @author zsq
     */
    public function add($requestData)
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['wallet_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->wallet_id;
        } else {
            return false;
        }
    }

    /**
     * @function 增加积分
     * @author zsq
     */
    public function raiseIntegral($wdata = array(), $requestData = array(), $operateData = array())
    {
        $fields = array(
            'wallet_integral' => array(
                "exp",
                "wallet_integral + {$requestData['integral']}"
            )
        );
        $whereCond = array(
            'wallet_id' => $wdata['wallet_id']
        );
        
        return $this->save($fields, $whereCond);
    }
}    