<?php 

namespace app\admin\validate;

use think\Validate;

class admin extends Validate
{
	protected $rule = [
        'name|用户名'      =>  'require|max:25',
        'prepwd|原始密码'  =>  'require|min:5',
        'pwd|密码'         =>  'require|min:5',
        'repwd|确认密码'   =>  'require|min:5|confirm:pwd',
    ];
    
    protected $message = [
        'name.require'      =>  '用户名必须填写',
        'name.max'	        =>	'用户名最多25位',
        'prepwd.require'    =>  '原始密码必须填写',
        'prepwd.min'        =>  '原始密码最少5位',
        'pwd.require'       =>  '密码必须填写',
        'pwd.min'	        =>	'密码最少5位',
        'repwd.require'     =>  '确认密码必须填写',
        'repwd.min'         =>  '确认密码最少5位',
        'repwd.confirm'     =>  '两次密码不一致',
    ];
    
    protected $scene = [
        'add'   =>  ['name', 'pwd', 'prepwd', 'repwd'],
        'edit'  =>  ['pwd', 'prepwd', 'repwd'],
        'login' =>  ['name', 'pwd'],
    ];
}