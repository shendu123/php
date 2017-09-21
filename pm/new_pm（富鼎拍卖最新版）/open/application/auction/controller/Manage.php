<?php
namespace app\auction\controller;

use app\common\controller\NoAuth;
use app\auction\model\Manage as Auction_Manage;

class Manage extends NoAuth {
	/**
	 * 拍品添加
	 */
	public function add() {
		$data = $this->_checkAdd();

		$goods_add_rs = curl_get_content(config("goods_api_url")."manage/add", 1, $data['goods'], $this->request->header('accesstoken'));
		if ($goods_add_rs->error != 0) {
			$this->_error($goods_add_rs->error, 500);
		}

		$data['auction']['goods_id'] = $goods_add_rs->goods_id;

		$rs = (new Auction_Manage())->add($data['auction']);

		return $rs ? ['error'=>0, 'auction_id'=>$rs] : $this->_error('商品挂牌失败', 500);


	}

	/**
	 * 拍品添加提交参数验证
	 */
	private function _checkAdd() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		if(true !== ($validate = $this->validate($this->request->post(), 'AuctionAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();
		$data['auction']['auction_mode'] = $post['mode'];
		$data['auction']['auction_name'] = $post['name'];
		$data['auction']['auction_type'] = $post['auction_type'];
		$data['auction']['member_id'] = $this->_uid;
		$data['auction']['auction_oprid'] = $this->_uid;
		$data['auction']['auction_succtype'] = $post['auction_succtype'];
		$data['auction']['auction_starttime'] = strtotime($post['auction_starttime']);
		$data['auction']['auction_endtime'] = strtotime($post['auction_endtime']);
		$data['auction']['auction_onset_price'] = $post['auction_onset_price'];
		$data['auction']['auction_reserve_price'] = $post['auction_reserve_price'];
		$data['auction']['auction_apply_stuff'] = $post['auction_apply_stuff'];
		$data['auction']['auction_buier_price'] = $post['auction_buier_price'];
		$data['auction']['auction_seller_price'] = $post['auction_seller_price'];
		$data['auction']['auction_broker_price'] = $post['auction_broker_price'];
		$data['auction']['auction_succ_price'] = $post['auction_succ_price'];
		$data['goods']['cat_id'] = $post['cat_id'];
		$data['goods']['goods_name'] = $data['goods']['goods_title'] = $post['name'];
		$data['goods']['goods_keywords'] = $post['goods_keywords'];
		$data['goods']['goods_price'] = $post['goods_price'];
		$data['goods']['goods_pictures'] = $post['goods_pictures'];
		$data['goods']['goods_content'] = $post['goods_content'];
		$data['goods']['goods_thumb'] = $post['goods_thumb'];

		unset($post);

		return $data;
	}

}