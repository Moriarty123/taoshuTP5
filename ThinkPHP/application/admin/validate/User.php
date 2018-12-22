<?php 

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'user_name|用户名'      =>  'require|max:25',
        'user_pwd|密码'         =>  'require|min:5',
        'user_sex|性别'          =>'require'
        'nickname|昵称'          =>''
        'user_realname|真实姓名'          =>'require'
        'user_content|个人简介'          =>''
        'user_tel|联系方式'          =>'require|length:11 or length:6'
        'user_addr|地址'          =>'require'
        'user_img|头像'          =>''
        'grade|年级'          =>'require'
        'class_id|班级'          =>'require'
        'login_times|登录次数'          =>'require'
    ];
    
    protected $message = [
        'name.require'      =>  '用户名必须填写',
        'name.max'          =>  '用户名最多25位',
        'prepwd.require'    =>  '原始密码必须填写',
        'prepwd.min'        =>  '原始密码最少5位',
        'pwd.require'       =>  '密码必须填写',
        'pwd.min'           =>  '密码最少5位',
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