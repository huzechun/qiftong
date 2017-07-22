<?php namespace app\home\controller;


use think\Controller;
use think\Db;
use think\Session;

class Cart extends Controller{


    //添加购物车数据
    public function addcart(){

        if(request()->isPost()){

            //判断用户是否登录

            if(!Session::has('user')){

                return ['code'=>400,'msg'=>'请先登录'];

            }else{

                $add_data = input('post.');

                if(is_array($add_data)) {

                    //购物车编号
                    $cart_no = 'CN'.date('Ymd') .str_pad(mt_rand(1,99999),5,'0', STR_PAD_LEFT);

                    // 获取表中项目价格

                    $project = Db::name('service_project')->where('id',$add_data['project_id'])->find();

                        $add_data['member_id']     = $add_data['member_id'];
                        $add_data['project_id']    = $add_data['project_id'];
                        $add_data['project_name']  = $project['project_name'];
                        $add_data['price']         = $project['price'];
                        $add_data['num']           = 1;
                        $add_data['total']         = $project['price']*1;
                        $add_data['cart_no']       = $cart_no;
                        $add_data['cart_time']     = time();

                    $add_cart = Db::name('cart')->insert($add_data);

                    $user = Session::get('user');

                    $mid  = $user['id'];

                    if($add_cart){

                        //购物车数量变更

                         $num = Db::name('cart')->where(['member_id'=>$mid,'status'=>1])->count();

                         //重新设置Session数据

                         Session::set('cart_num', $num);

                         $this->assign('sum_data',$num);

                          return ['code'=>200,'msg'=>'加入购物车成功'];

                      }else{

                          return ['code'=>400,'msg'=>'加入购物车失败'];

                    }
                }
            }
        }
    }


    //购物车数据
    public function index(){

        //判断用户是否登录
        if(!Session::has('user')){

            return ['code'=>400,'msg'=>'请先登录'];

        }else{

            //已登录会员 获取购物车数据

            $user = Session::get('user');

            $member_id = $user['id'];

            $data = Db::name('cart')->where(['member_id'=>$member_id,'status'=>1])->select();

            $this->assign('data',$data);

            //获取总价格
            $sum_data = Db::name('cart')->where(['member_id'=>$member_id , 'status'=>1])->sum('total');

            $this->assign('sum_data',$sum_data);

            return view();

        }
    }

    //异步更新购物车数量

    public function update_num() {

        if(request()->isAjax()){

            $num_data = input('post.');

            $id  = $num_data['id'];
            $user = Session::get('user');
            $mid = $user['id'];

            //获取购物车表中价格

            $cart_data = Db::name('cart')->where('id',$id)->find();

            $num_data['price'] = $cart_data['price'];

            $num = $num_data['num'];

            $num_data['total'] = $cart_data['price'] * $num;

            //更新数量和总计
            Db::name('cart')->where('id',$num_data['id'])

                ->update(['num'=>$num_data['num'],'total'=>$num_data['total']]);

            $data = Db::name('cart')->where('id',$id)->find();

            // 返回数据到前台
            $sum_data = Db::name('cart')->where(['member_id'=>$mid , 'status'=>1])->sum('total');

            $this->assign('sum_data',$sum_data);

            return ['data'=>$data, 'total' => $sum_data ,'code'=>200,'msg'=>'修改成功'];

        }
    }


    //删除购物车数据

    public function del_cart(){

        if(request()->isPost()){

            $del = input('post.id');

            $user = Session::get('user');

            $mid = $user['id'];

            $del_data = Db::name('cart')->where('id',$del)->delete();

            // 删除后的总计
            $total = Db::name('cart')->where(['member_id'=>$mid , 'status'=>1])->sum('total');
            
            if($del_data){

                 //刷新购物车数据
                
                $lnum = Db::name('cart')->where(['member_id'=>$mid,'status'=>1])->count();

                // 重新设置数量
                Session::set('cart_num',$lnum);

                return ['data'=>$total , 'num' => $lnum,'code'=>200,'msg'=>'删除成功'];

            }else {

                return ['code' => 400, 'msg' => '删除失败'];
            }
        }
    }

}