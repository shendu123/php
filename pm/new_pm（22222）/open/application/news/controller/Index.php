<?php
namespace app\news\controller;

use app\common\controller\NoAuth;
use app\news\model\NewsArticle;
use app\news\model\NewsCategory;

class Index extends NoAuth
{

	/**
	 * 圈子关注列表
	 */
	public function article_attention_list() {
		$this->_checkLogin();

		$get = $this->request->get();
        $page['pageSize']= isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');
        $page['page']=isset($get['page']) ? intval($get['page']) : 1;

		$business_attention_rs = curl_get_content(config("basic_api_url")."Business_Attention/", 0, '', $this->request->header('accesstoken'));
		if ($business_attention_rs->error != 0) {
			$this->_error('system error', 500);
		}

		$business_ids = [];
		foreach ($business_attention_rs->result as $key => $value) {
			$business_ids[] = $value->business_id;
		}
		if (empty($business_ids)) {
			return ['error'=>0, 'result'=>[]];
		}

        $where['status']=1;	
        $where['na.business_id']=['in', $business_ids];	
		$data = (new NewsArticle())->articleList($page, $where);

		return ['error'=>0, 'result'=>$data];

	}

	/**
	 * 获取频道列表
	 */
	public function category()
	{
        $where['is_show']=1;

        return (new NewsCategory())->catList(config('pageSize'), $where);
	}

	/**
	 * 竞拍协议
	 */
	public function auction_agreement()
	{
        $where['id']=config('auction_agreement_article_id');
        $data = (new NewsArticle())->articleDetail($where);
        return ['error'=>0, 'content'=>$data['content']];
	}
	
	/**
	 * 隐私协议
	 */
	public function secret_agreement()
	{
	    $where['id']=config('secret_agreement_article_id');
	    $data = (new NewsArticle())->articleDetail($where);
	    return ['error'=>0, 'content'=>$data['content']];
	}
	
	/**
	 * 注册协议
	 */
	public function register_agreement()
	{
	    $where['id']=config('register_agreement_article_id');
	    $data = (new NewsArticle())->articleDetail($where);
	    return ['error'=>0, 'content'=>$data['content']];
	}

}