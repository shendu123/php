<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class DeliveryAddress extends Model
{

    protected $table = 'opb_delivery_address';

    public $_tableFields = array(
        'id' => 'int', // 地址id
        'addr_type' => 'int', // 收货地址类型：0会员，10企业
        'owner_id' => 'int', // 所有者id，若为会员则填会员id，若为企业则填com_id
        'province' => 'int', // 省id 旧province
        'city' => 'int', // 城市id 旧city
        'area' => 'int', // 区、县id 旧area
        'addr_address' => 'varchar', // 详细地址 旧address
        'addr_postalcode' => 'varchar', // 邮政编码 旧postalcode
        'addr_truename' => 'varchar', // 收件人姓名 旧truename
        'addr_mobile' => 'varchar', // 手机号 旧mobile
        'addr_phone' => 'varchar', // 电话号码 旧phone
        'addr_isdefault' => 'int', // 0初始 1默认
        'addr_uptime' => 'int', // 修改时间
        'addr_intime' => 'int', /* 创建时间 */
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['addr_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['addr_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->id;
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
        $fields['addr_uptime'] = $_SERVER['REQUEST_TIME'];
        $wdata = array(
            'id' => $fields['id']
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
        
        if (! empty($wdata['owner_id'])) {
            $whereCond['owner_id'] = $wdata['owner_id'];
        }
        if (isset($wdata['addr_type'])){
            $whereCond['addr_type'] = $wdata['addr_type'];
        }
    
        $list = Db::table('opb_delivery_address')
        ->where($whereCond)
        ->field('*')
        ->order('addr_isdefault desc')
        ->select();
    
        $count = Db::table('opb_delivery_address')
        ->where($whereCond)
        ->count();
    
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

        $provinceIds = array_column($data, 'province');
        $cityIds = array_column($data, 'city');
        $areaIds = array_column($data, 'area');
        $mixAreaIds = array_merge((array)$provinceIds, (array)$cityIds, (array)$areaIds);
        $mixAreaIds = array_unique(array_filter($mixAreaIds));
        // 解析province city area
        $areaModel = new \app\basic\model\ChinaArea();
        $wdata = array(
            'ids' => implode(',', $mixAreaIds)
        );
        $areaData = $areaModel->getBy($wdata);
        $areaMaps = array_column($areaData, 'region_name', 'id');
    
        foreach ($data as $key => $val) {
            $data[$key]['addr_intime_tag'] = date('Y-m-d H:i', $val['addr_intime']);
            $data[$key]['addr_uptime_tag'] = date('Y-m-d H:i', $val['addr_uptime']);
            $data[$key]['province_tag'] = $areaMaps[$val['province']];
            $data[$key]['city_tag'] = $areaMaps[$val['city']];
            $data[$key]['area_tag'] = $areaMaps[$val['area']];
        }
    
        return $data;
    }
    
    /**
     * @function 删除
     * @author ljx
     *
     * @param integer $wdata['id'] id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $wdata['ids']
        );
        if(isset($wdata['owner_id']) && !empty($wdata['owner_id'])){
            $whereCond['owner_id'] = $wdata['owner_id'];
        }
        
        return Db::table('opb_delivery_address')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        $row = Db::table('opb_delivery_address')->where('id',$wdata['id'])->find();
        if(!empty($row)){
            $row = $this->parseDetailData($row);
        }

        return $row;
    }
    
    /**
     * @function 解析详情
     * @author ljx
     */
    function parseDetailData($data = array()){
        // 解析province city area
        $areaModel = new \app\basic\model\ChinaArea();
        $wdata = array(
            'ids' => "{$data['province']},{$data['city']},{$data['area']}"
        );
        $areaData = $areaModel->getBy($wdata);
        $areaMaps = array_column($areaData, 'region_name', 'id');

        $data['province_tag'] = $areaMaps[$data['province']];
        $data['city_tag'] = $areaMaps[$data['city']];
        $data['area_tag'] = $areaMaps[$data['area']];
        
        return $data;
    }
    
    /**
     * @function 反设默认地址
     * @author ljx
     * @see 除了给定的id，其余的项目设置为非默认，限定在用户集下 
     */
    public function unsetDefault($wdata = array(), $operateData = array()){
        $sql_query = "
        UPDATE opb_delivery_address 
            SET addr_isdefault = 0,addr_uptime = '{$_SERVER['REQUEST_TIME']}'
        WHERE id != '{$wdata['id']}' AND owner_id = '{$wdata['owner_id']}' AND addr_isdefault = 1
        ";
        return Db::query($sql_query);
    }
    
    /**
     * @function 获取默认收货地址
     * @author ljx
     */
    public function getDefault($wdata = array(), $operateData = array()){
        $whereCond = array(
            'owner_id' => $wdata['owner_id'],
            'addr_type' => $wdata['addr_type'],
            'addr_isdefault' => 1
        );
        $row = Db::table('opb_delivery_address')->where($whereCond)->find();
        if(!empty($row)){
            $row = $this->parseDetailData($row);
        }
        
        return $row;
    }
    
    
    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓下面的以后要废弃掉↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓//
    
    
    public function updateById($po)
    {
        $res = Db::table('opb_delivery_address')->where([
            'id' => $po['id']
        ])->update($po);
        if ($res) {
            return $res;
        } else {
            return [
                "type" => "error",
                "tip" => "跟新出错了"
            ];
        }
    }

    public function saveData($po, $uid)
    {
        $da['addr_type'] = $this->issetData($po['addr_type'], "-");
        $da['owner_id'] = $this->issetData($uid, 0);
        
        $da['province'] = $this->issetData($po['province'], 2);
        $da['city'] = $this->issetData($po['city'], 2);
        $da['area'] = $this->issetData($po['area'], 0);
        
        $da['addr_address'] = $this->issetData($po['addr_address'], '-');
        $da['addr_postalcode'] = $this->issetData($po['addr_postalcode'], 0);
        $da['addr_truename'] = $this->issetData($po['addr_truename'], 0);
        $da['addr_mobile'] = $this->issetData($po['addr_mobile'], 0);
        $da['addr_phone'] = $this->issetData($po['addr_phone'], '-');
        
        $res = Db::table('opb_delivery_address')->insert($da);
        
        if ($res) {
            return 1;
        } else {
            return $res;
        }
    }

    public function issetData(&$a, $b)
    {
        return isset($a) ? $a : $b;
    }

    public function getDataById($id)
    {
        $res = Db::query("SELECT da.`id`,da.`owner_id`,da.`addr_isdefault` ,da.`addr_mobile`,da.province,da.city,da.area,da.`addr_truename`,da.`addr_address`,da.`addr_type`,ca.`region_name` AS sheng,ca2.`region_name` AS shi,ca3.`region_name` AS xian  FROM `opb_delivery_address`  da 
			LEFT JOIN `opb_china_area` ca ON da.`province` = ca.`id`
        	LEFT JOIN `opb_china_area` ca2 ON da.`city` = ca2.`tmall_areaid`
        	LEFT JOIN `opb_china_area` ca3 ON da.`area` = ca3.`id`
        	WHERE da.`id` = {$id}
        	");
        // var_dump($res);
        if ($res) {
            return $res;
        } else {
            return 0;
        }
    }

    public function getDataListById($id)
    {
        $res = Db::query("SELECT da.`id`,da.`owner_id`,da.`addr_isdefault` ,da.province,da.city,da.area,da.`addr_mobile`,da.`addr_truename`,da.`addr_address`,da.`addr_type`,ca.`region_name` AS sheng,ca2.`region_name` AS shi,ca3.`region_name` AS xian  FROM `opb_delivery_address`  da 
			LEFT JOIN `opb_china_area` ca ON da.`province` = ca.`id`
        	LEFT JOIN `opb_china_area` ca2 ON da.`city` = ca2.`tmall_areaid`
        	LEFT JOIN `opb_china_area` ca3 ON da.`area` = ca3.`id`
        	WHERE da.`owner_id` = {$id}
        	");
        // var_dump($res);
        if ($res) {
            return $res;
        } else {
            return $res;
        }
    }
}