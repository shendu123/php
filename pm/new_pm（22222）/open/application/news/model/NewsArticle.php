<?php
namespace app\news\model;
use think\Model;
use think\Db;
class NewsArticle extends Model {
    
    public function articleList($page,$where){
       
        $list = Db::name('NewsArticle')->alias('na')
                ->join('NewsCategory','NewsCategory.id=na.cid','LEFT')
                ->field('na.*,NewsCategory.name')
                ->where($where)
                ->order('na.id desc')
                ->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])
                ->select();
        $count=Db::name('NewsArticle')->alias('na')
                ->join('NewsCategory','NewsCategory.id=na.cid','LEFT')
                ->field('na.*,NewsCategory.name')
                ->where($where)->count();
        foreach($list as $k=>$v){
			$list[$k] = array_merge($v,$this->DataHandle($v));
        }
        $aList=[
            'data'=>$list,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count
        ];
        return $aList;
    }
    
    public function indexArticleList(){
        $arr_id=[2=>'gsgg',3=>'xwzx',4=>'scpyj'];
        foreach($arr_id as $k=>$v){
            $where['cid']=$k;
            $page['page']=1;
            $page['pageSize']=7;
            $list=$this->articleList($page,$where);
            $alist[$v][]=$list['data'];
        }
        return $alist;
    }
    
    public function articleDetail($where){
        $this->where($where)->setInc('view');
		$info =  Db::name('NewsArticle')->where($where)->find();
        return $info ? $this->DataHandle($info) : [];
    }
	
	public function add($data , $user){
		$data = $this->FormHandle($data, $user);
		return $this->save($data) !== false;
	}
	
	public function edit($data , $user){
		$data = $this->FormHandle($data, $user, 'edit');
		return $this->save($data , ['id'=>$data['id']]) !== false;
	}
	
	//表单数据处理
	public function FormHandle($data,$user,$method = 'add'){
		if($method == 'add'){
			$data['create_time']=time();
		}else{
			unset($data['create_time']);
		}
		$data['content'] = htmlspecialchars_decode($data['content']);
		$data['author'] = $user['user']['user_name']; 
		$data['business_id'] = $user['business']['business_id']; 
		if(isset($data['thumb_picArray']) && $data['thumb_picArray']){
			$data['thumb_pic']=$data['thumb_picArray'];
		}
		unset($data['thumb_picArray']);	
		unset($data['thumb_pic_count']);	
		return $data;
	}
	
	private function DataHandle($data){		
		$arrThumb = [];
		foreach(explode(',', $data['thumb_pic']) as $key => $val){
			if($val){
				$arrThumb[$key] = array(
					'file_path' => $val,
					'url' => $val
				);					
			}
		}

		$data['thumb_pic'] = $arrThumb;
		$data['thumb_pic_count'] = count($arrThumb);
		$data['create_time']=date("Y-m-d H:i:s",$data['create_time']);
		$data['content']=filter_content(htmlspecialchars_decode($data['content']));
		return $data;
	}
    
    //检测文章是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }
    
    
}

