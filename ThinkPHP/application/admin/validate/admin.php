<?php 

namespace app\admin\validate;

use think\Validate;

class admin extends Validate
{
	protected $rule = [
        'name|用户名'  =>  'require|max:25',
        'pwd|密码' =>  'require|min:5',
    ];
    
    protected $message = [
        'name.require'  =>  '用户名必须填写',
        'name.max'	=>	'用户名最多25位',
        'pwd.require' =>  '密码必须填写',
        'pwd.min'	=>	'密码最少5位'
    ];
    
    protected $scene = [
        // 'add'   =>  ['name','email'],
        // 'edit'  =>  ['email'],
    ];
}