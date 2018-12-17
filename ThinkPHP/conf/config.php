<?php

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,


    //模板替换
    // 'view_replace_str'  =>  [
    //     '__PUBLIC__'        =>'/public/',
    //     '__ROOT__'          => '/',
    //     '__CSS__'           =>  '/static/css',
    //     '__IMG__'           =>  '/static/images'
    // ],


    //验证码设置
    'captcha'=>[
        //字体大小
        'fontSize'      =>  20,
        //验证码长度(位数)
        'length'        =>  4,
        //使用曲线
        'useCurve'      =>  false,
        //使用杂点
        'useNoise'      =>  false,
        //使用背景图片
        'useImgBg'      =>  false,
        //使用中文验证码
        //'useZh'=>true,
    ],



];