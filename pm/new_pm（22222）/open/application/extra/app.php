<?php
return [
    'model_path' => 'common',
    'validate_path' => 'common',
    'white_request' => [
        'basic/Login/*',
        'basic/Token/refreshtoken',
        'basic/System/all',
        'basic/Node/route',
        'basic/Node/menu',
        'basic/Node/allNodes',
        'basic/Business/businesslist',
        'basic/Business/sonbusinesslist',
        'basic/Business/businessview',
        'basic/Business/getparentbusiness',
        'basic/Business/percent',
        'basic/Business/checkCodeIsExist',
        'basic/Business/businessinfo',
        'basic/Business/improveinfo',
        'auction/Admin/detail',
        'goods/Goods/detail',
		'crowd/Admin/addGoods',
		'auction/Admin/addGoods',
		'item/Admin/addGoods',
		'goods/SpecGoods/manage',
		'goods/Category/catList',
        'basic/Role/systemRole',
		'adv/Adv/changeSortOrShow',
		'goods/SpecGoods/goodsSpecList'
    ],
    'super_uids' => [
        1,
    ]
];