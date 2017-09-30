<?php

namespace app\basic\validate;

use think\Validate;

class BusinessCompany extends Validate {
    protected $rule = [
		['com_name','require|unique:BusinessCompany,com_name','公司名称不能为空！|公司名称已存在！'],
		['com_ucredit','require|unique:BusinessCompany,com_ucredit','统一信用代码不能为空！|统一信用代码已存在！'],
		//['com_legal_mobile','require','法人手机号不能为空！'],
		['com_legal_name','require','法人姓名不能为空！'],
		['com_contact_mobile','require','联系人手机号不能为空！'],
		['com_contact_name','require','联系人姓名不能为空！'],
		['com_legal_idcard','require','法人身份证号不能为空'],
		['com_license', 'require', '请上传营业执照'],
		['com_legal_idcard_front', 'require', '请上传法人身份证正面'],
		['com_legal_idcard_back', 'require', '请上传法人身份证反面'],
    ];
	

}