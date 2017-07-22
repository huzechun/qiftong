<?php namespace app\home\validate;


use think\Validate;

class User extends Validate{

    protected $rule = [
        ['mobilephone','require|max:11|min:11','请输入手机号码|手机号码格式不符|手机号码格式不符'],
        ['email','require|email','请填写邮箱|邮箱格式错误'],
        ['member_name','require','请填写姓名或称呼'],
        ['user_password','require','请输入密码'],
        //['captcha','require|captcha','验证码错误']
        //['mobile.mobile','手机格式错误']
    ];

}
