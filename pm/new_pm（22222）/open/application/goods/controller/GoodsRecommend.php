<?php
namespace app\goods\controller;

use app\common\controller\NoAuth;
use GuzzleHttp\json_encode;
use app\goods\model\Recommend;
class GoodsRecommend extends NoAuth{
	
	public function __construct(){
		parent::__construct();
	}
	
	//将推荐商品数据写入json文件中
	public function write_to_file(){
		$get_params = $this->request->get();
		// 区块id,必传
		$pid = isset($get_params['pid']) && $get_params['pid'] ? intval($get_params['pid']) : 0;
		
		// key,必传
		$key = isset($get_params['key']) && $get_params['key'] ? $get_params['key'] : '';
		$time = isset($get_params['time']) && $get_params['time'] ? $get_params['time'] : '';
		$sign_key = config('SIGN_KEY');
		
		// 参数校验
		if(!$pid){
			$this->_error('参数错误', 400);
		}
		if(md5(md5($pid).$time.$sign_key) != $key){
			$this->_error('forbidden', 403);
		}
		
		// 获取该区块的推荐列表
		$data = (new Recommend())->getRecommend($pid);
		
		if(!$data){
			return ['error'=>0,'msg'=>'没有数据'];
		}
		
		$return_data = array();
		// 数据处理
		foreach ($data as $info){
			$detail = array();
			$id = $info['rec_stuff_id'];
			//业务类型 0纯粹商品 【11-20auction业务用】11:竞价 12拍卖 13vip 14专场 15拍卖会 【21-30crowd业务用】21申购
			if ($info['rec_stuff_type']>=11 && $info['rec_stuff_type']<=20){ //stuff_type:11-20:auction.id
				$auction_result = curl_get_content(config("auction_api_url")."index/detail?aid={$id}",0,"","",1);
				$detail = $auction_result['result'];
			}elseif ($info['rec_stuff_type']>=21 && $info['rec_stuff_type']<=30){ //stuff_type:21-30:crowd.id
				$crow_result = curl_get_content(config("crowd_api_url")."crowd/index/detail?crowd_id={$id}",0,"","",1);
				$detail = $crow_result['result'];
			}
			$info['info'] = $detail;
			$return_data[] = $info;
		}
		
		//将返回数据写入文件中
		$file_path = $_SERVER["DOCUMENT_ROOT"].'/json/goods_recomend_'.$pid.'.json';
		try {
			$file = fopen($file_path,"w");
			if(fwrite($file,json_encode($return_data)) == false){
				$this->_error('写入文件失败', 400);
			}
			fclose($file);
		}catch (Exception $e){
			$this->_error($e->getMessage(), 400);
		}
		
		return ['error'=>0,'msg'=>'数据写入文件成功'];
	}	
	
}