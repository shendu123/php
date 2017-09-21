<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 钱包模型
 * @author ljx
 */
class Wallet extends Model
{

    protected $table = 'opf_wallet';

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
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
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
     * @function 编辑
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $wdata = array(
            'wallet_id' => $fields['wallet_id']
        );
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 列表
     * @author ljx
     *        
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        
        if (isset($wdata['user_ids']) && ! empty($wdata['user_ids'])) {
            $whereCond['user_id'] = array(
                'in',
                $wdata['user_ids']
            );
        }
        
        if (isset($wdata['wallet_ids']) && ! empty($wdata['wallet_ids'])) {
            $whereCond['wallet_id'] = array(
                'in',
                $wdata['wallet_ids']
            );
        }
        
        $list = Db::table('opf_wallet')->where($whereCond)
            ->field('*')
            ->order('wallet_id desc')
            ->select();
        
        $count = Db::table('opf_wallet')->where($whereCond)->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list);
        }
        
        $result = array(
            'count' => $count,
            'data' => $list
        );
        
        return $result;
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        foreach ($data as $key => $val) {
            isset($data[$key]['wallet_intime']) ? $data[$key]['wallet_intime_tag'] = fd_checktime($data[$key]['wallet_intime']) : '';
            isset($data[$key]['wallet_outtime']) ? $data[$key]['wallet_outtime_tag'] = fd_checktime($data[$key]['wallet_outtime']) : '';
        }
        
        return $data;
    }

    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array())
    {
        $data = Db::table('opf_wallet')->where($wdata)->find();
        if (! empty($data)) {
            unset($data['wallet_checktoken']);
        }
        
        return $data;
    }

    /**
     * @function 增加
     * @author ljx
     * @param $requestData['wallet_id']
     * @param $requestData['amount'] 金额
     */
    public function raise($requestData = array(), $operateData = array())
    {
        return Db::table('opf_wallet')->where('wallet_id', $requestData['wallet_id'])->update([
            'wallet_available_price' => [
                'exp',
                "wallet_available_price + {$requestData['amount']}"
            ],
            'wallet_checktoken' => $this->genToken()
        ]);
    }

    /**
     * @function 减少
     * @author ljx
     * @param $requestData['wallet_id']
     * @param $requestData['amount'] 金额
     */
    public function reduce($requestData = array(), $operateData = array())
    {
        return Db::table('opf_wallet')->where('wallet_id', $requestData['wallet_id'])->update([
            'wallet_available_price' => [
                'exp',
                "wallet_available_price - {$requestData['amount']}"
            ],
            'wallet_checktoken' => $this->genToken()
        ]);
    }

    /**
     * @function 冻结
     * @author ljx
     * @param $requestData['wallet_id']
     * @param $requestData['amount'] 金额
     */
    public function freeze($requestData = array(), $operateData = array())
    {
        return Db::table('opf_wallet')->where('wallet_id', $requestData['wallet_id'])->update([
            'wallet_available_price' => [
                'exp',
                "wallet_available_price - {$requestData['amount']}"
            ],
            'wallet_freeze_price' => [
                'exp',
                "wallet_freeze_price + {$requestData['amount']}"
            ],
            'wallet_checktoken' => $this->genToken()
        ]);
    }

    /**
     * @function 冻结余额释放【TODO 这个方法只能我去用 没定义好 ljx-2017-08-17】
     * @author ljx
     * @param $requestData['wallet_id'] 钱包id
     * @param $requestData['deposit_price'] 本次涉及的冻结金额数目
     * @param $requestData['deposit_free_price'] 本次需要解冻的金额数目
     */
    public function release($requestData = array(), $operateData = array())
    {
        $balance_diff_price = 0; // 余额变动金额数
        $avaliable_diff_price = 0; // 可用余额变动金额数
        $freeze_diff_price = 0; // 冻结金额变动金额数
        
        $balance_diff_price = $requestData['deposit_price'] - $requestData['deposit_free_price']; // 结果一般为小于等于0
        $avaliable_diff_price = $requestData['deposit_price'] - $requestData['deposit_free_price']; // 结果一般为小于等于0
        $freeze_diff_price = $requestData['deposit_price'];
        
        return Db::table('opf_wallet')->where('wallet_id', $requestData['wallet_id'])->update([
            'wallet_available_price' => [
                'exp',
                "wallet_available_price - {$avaliable_diff_price}"
            ],
            'wallet_freeze_price' => [
                'exp',
                "wallet_freeze_price - {$freeze_diff_price}"
            ],
            'wallet_checktoken' => $this->genToken()
        ]);
    }

    /**
     * @function 扣除保证金
     * @author ljx
     * @see 适用于 直接扣减冻结金额的业务 不涉及到 账户余额 可用余额的变动
     */
    public function minusDeposit($wdata = array(), $requestData = array(), $operateData = array())
    {
        $fields = array(
            'wallet_freeze_price' => array(
                "exp",
                "wallet_freeze_price - {$requestData['amount']}"
            )
        );
        
        return $this->save($fields, $wdata);
    }

    /**
     * @function 增加积分
     * @author ljx
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

    /**
     * @function 生成密钥
     * @author ljx
     *         TODO
     */
    private function genToken()
    {
        return '';
    }
}



























