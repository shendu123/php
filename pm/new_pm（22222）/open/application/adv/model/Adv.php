<?php
namespace app\adv\model;
use think\Model;
use think\Db;
class Adv extends Model {
    
    public function advList($page,$where){
       
        $list = Db::name('Adv')->alias('a')
                ->join('AdvPosition','AdvPosition.id=a.pid','LEFT')
                ->field('a.*,AdvPosition.name')
                ->where($where)
                ->order('a.id desc')
                ->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])
                ->select();
        $count=Db::name('Adv')->alias('a')
                ->join('AdvPosition','AdvPosition.id=a.pid','LEFT')
                ->where($where)->count();
        foreach($list as $k=>$v){
			$list[$k] = array_merge($v,$this->DataHandle($v));
        }
        $aList=[
            'data'=>$list,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count,
        ];
        return $aList;
    }
	
	public function advInfo($where){
		$info =  Db::name('Adv')->where($where)->find();
        return $info ? $this->DataHandle($info) : [];
	}
		
	public function add($data){
		$data = $this->FormHandle($data);
		return $this->save($data) !== false;
	}
	
	public function edit($data){
		$data = $this->FormHandle($data, 'edit');
		return $this->save($data , ['id'=>$data['id']]) !== false;
	}
	
	//表单数据处理
	public function FormHandle($data,$method = 'add'){
		$data['start_time'] = strtotime($data['start_time']);
		$data['end_time'] = strtotime($data['end_time']);
		if(isset($data['adv_picArray']) && $data['adv_picArray']){
			$data['adv_pic']=$data['adv_picArray'];
		}
		unset($data['adv_picArray']);		
		return $data;
	}
	
	private function DataHandle($data){		
		$arrThumb = [];
		foreach(explode(',', $data['adv_pic']) as $key => $val){
			if($val){
				$arrThumb[$key] = array(
					'file_path' => $val,
					'url' => $val
				);					
			}
		}

		$data['adv_pic'] = $arrThumb;
		$data['start_time']=date("Y-m-d H:i:s",$data['start_time']);
		$data['end_time']=date("Y-m-d H:i:s",$data['end_time']);
		return $data;
	}
    
    //检测广告是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }
    
    
}

