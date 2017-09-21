<?php
namespace app\goods\controller;

use app\common\controller\NoAuth;
use app\goods\model\Recommend;
use app\goods\model\Category;
use app\goods\model\Brand;
use app\goods\model\Spec;

class Index extends NoAuth {

	/**
	 * 获取推荐
	 */
	public function recommend() {
		$pid = (int)$this->request->get('pid');

		$data = (new Recommend())->getRecommend($pid);

		
		return ['error'=>0, 'result'=>$data];
		
	}

	/**
	 * 获取分类
	 */
	public function category() {
		$cid = (int)$this->request->get('cid');
		$business_id = (int)$this->request->get('business_id');

		$where_str = '';
		if ($business_id > 0) {
			$where_str = " and business_id = {$business_id} ";
		}
		$is_recomend = (int)$this->request->get('is_recomend');
		if ($is_recomend == 1) {
			$where_str = " and cat_recomend = {$is_recomend} ";
		}

		$data = Category::where("cat_pid = {$cid} {$where_str} and is_show = 1")->order('cat_sort desc')->column('id,cat_name,cat_icon');

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 获取品牌
	 */
	public function brand() {
		$cid = (int)$this->request->get('cid');


		$data = Brand::where("cat_id = {$cid}")->column('id,brand_name,brand_icon');

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 获取分类及品牌
	 */
	public function category_brand() {
		$category_data = Category::where("business_id = 0")->order('cat_sort desc')->column('id,cat_name,cat_icon');
		
		$tmp = $data = [];
		foreach ($category_data as $key=>$value) {
			$tmp['data'][$value['id']] = $key;
			$tmp['cid'][] = $value['id'];
			$data[$key]['category'] = $value;
			$data[$key]['brand'] = [];
		}

		if (empty($tmp['cid'])) {
			return ['error'=>0, 'result'=>[]];
		}

		$cid_str = join(',', $tmp['cid']);

		$brand_data = Brand::where("cat_id in ({$cid_str})")->column('id,cat_id,brand_name,brand_icon');
		foreach ($brand_data as $key => $value) {
			$data[$tmp['data'][$value['cat_id']]]['brand'][] = $value;
		}

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 获取商品sku
	 */
	public function spec_good() {
		$good_id = (int)$this->request->get('good_id');
		if($good_id == 0) {
			$this->_error("参数错误");
		}

		$data = (new Spec())->spec_good($good_id);

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 获取商品规格重要数据
	 */
	public function spec_important_data() {
		$post = json_decode(html_entity_decode($this->request->post('s')), true);
		if (empty($post)) {
			$this->_error('参数错误', 400);
		}

		$data = [];
		foreach ($post as $val) {
			$tmp = [];
			if (intval($val['goods_id']) == 0) {
				$this->_error('参数错误', 400);
			}
			$val['spec_key'] = empty($val['spec_key']) ? '' : $val['spec_key'];
			$data[$val['goods_id']] = (new Spec())->spec_good_important_data($val['goods_id'], $val['spec_key']);;
		}

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 获取商品规格重要数据
	 */
	public function sku_data() {
		$post = json_decode(html_entity_decode($this->request->post('s')), true);
		if (empty($post)) {
			$this->_error('参数错误', 400);
		}

		$data = [];
		foreach ($post as $val) {
			$tmp = [];
			if (intval($val['goods_id']) == 0) {
				$this->_error('参数错误', 400);
			}

			$val['spec_key'] = empty($val['spec_key']) ? '' : $val['spec_key'];
			
			$data[$val['goods_id']] = (new Spec())->sku_data($val['goods_id'], $val['spec_key']);;
		}

		return ['error'=>0, 'result'=>$data];
	}

}