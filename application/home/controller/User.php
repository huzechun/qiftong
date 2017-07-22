<?php namespace app\home\controller;

use app\home\model\Cart;
use app\home\model\Member;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Loader;
use think\Session;


class User extends Controller{


    //加载注册

    public function register(){

        return view();
    }


    //注册

    public function to_register(){

        if(request()->isPost()){

            $mobilephone = input('post.phone');

            $member_name = input('post.username');

            $user_password = input('post.pwd');

            if (!empty($mobilephone) && !empty($user_password)) {

                // 判断该用户是否已经注册

                $select = Db::name('member')->where('mobilephone', $mobilephone)->find();

                if ($select) {

                    //$this->assign('data',['data'=>'该用户已注册','code'=>400]);

                    return ['code'=> 400 , 'msg' => '该用户已注册'];
                }
            }

            // 处理验证码
            if (!captcha_check(input('post.captcha'))) {

                //$this->assign('data',['data'=>'验证码有误','code'=>400]);

                return ['code'=> 400 , 'msg' =>'验证码有误'];
            };

            $data = [
                'mobilephone' => $mobilephone,
                'email' => input('post.email'),
                'member_name' => $member_name,
                'user_password' => $user_password
            ];

            //验证规则
            $validate = Loader::validate('User');

            if (!$validate->check($data)) {

                //$this->assign('data',['data'=>$validate->getError(),'code'=>400]);

                return ['data'=>$validate->getError(),'code'=>400];

            } else {
                //注册信息
                $db = [
                    'mobilephone' => $mobilephone,
                    'email'       => input('post.email'),
                    'member_name' => $member_name,
                    'user_password' => md5($user_password),
                    'create_time' => time()
                ];

                $insert = Db::name('member')->insert($db);

                if ($insert) {

                    $user = Db::name('member')->where(['mobilephone'=>$mobilephone])->find();

                    Session::set('user',$user);

                    //$this->assign('data',['data'=>'注册成功','code'=>200]);

                    return ['code'=> 200 , 'msg'=> '注册成功'] ;

                    //return view();
                }
            }
        }

    }

    //加载登录
    public function login(){

       return view();
    }

    //登录
    public function to_login(){

        if(request()->isPost()){

            $mobilephone   =  input('post.phone');

            $user_password =  md5(input('post.pwd'));


            //验证用户名
            $user = Db::name('member')->where(['mobilephone'=>$mobilephone,'user_password'=>$user_password])->find();


            if($user){

                if(!empty(input('post.check'))){

                    Cookie::set('pwd',$user_password,time()+3600*24*7,'/');

                }else{

                    Cookie::set('pwd',$user_password,time()-1,'/');
                }

                Session::set('user',$user);

                $user = Session::get('user');

                //return ['user'=> $user];

                //$this->assign('user',['user'=>$user]);

                //购物车里数量

                $member_id = $user['id'];

                $lnum = Db::name('cart')->where(['member_id'=>$member_id,'status'=>1])->count();

                Session::set('cart_num',$lnum);
                

                return ['user'=> $user ,'msg'=>'登录成功','code'=>200];

                //$this->assign('data',['data'=>'登录成功','code'=>200]);

            }else{

                //$this->assign('data',['data'=>'用户名或密码错误','code'=>400]);

                return ['msg'=>'用户名或密码错误','code'=>400];

            }
        }
    }



    //会员信息
    public function member()
    {

        $user =  Session::get('user');

        $mid  =  $user['id'];

        $member_info = Db::name('member')->where('id', $mid)->find();

        //dump($member_info);

        //return ['member_info' => $member_info];

        $this->assign('member_info',$member_info);

        return view();
    }


    //编辑基本信息
    public function edit_info(){

        if (request()->isPost()) {


            $mobilephone   = Session::get('user.mobilephone');

            $email        = input('post.email');
            $member_name  = input('post.member_name');
            $address      = input('post.address');
            $industry     = input('post.industry');
            $city         = input('post.city');
            $way          = input('post.way');

            $info = Db::name('member')->where('mobilephone',$mobilephone)
                ->update([
                    'mobilephone' => $mobilephone,

                    'email'         => $email ,
                    'member_name'   => $member_name,
                    'address'       => $address,
                    'industry'      => $industry,
                    'city'          => $city,
                    'way'           => $way,
                    //'create_time'   => time()
                ]);

            return ['msg'=>'编辑成功' , 'code'=>200] ;

        }

        //return $this->fetch();
    }

    //修改密码
    public function edit_pwd(){

         if (request()->isPost()) {

                $user = Session::get('user');

                $id = $user['id'];

                $old_pwd = md5(input('post.old_pwd'));

                $new_pwd = md5(input('post.new_pwd'));

                $re_pwd  = md5(input('post.re_pwd'));

                $get_pwd = Db::name('member')

                    ->where('id', $id)->where('user_password', $old_pwd)

                    ->find();

                if ($get_pwd) {
                    
                        if ($re_pwd == $new_pwd) {

                            Db::name('member')->where('id', $id)->setField('user_password', $re_pwd);

                          return ['msg'=>'修改成功','code'=>200];


                        } else {

                            return ['msg'=>'新旧密码不一致','code'=>400];

                        }
                }else{

                    return ['msg'=>'旧密码输入有误','code'=>400];

                }
        }
    }


    //退出
    public function login_out(){

        Session::delete('user');

        Session::set('cart_num',0);

       return ['msg'=>'退出成功' , 'code'=>200] ;

    }

}