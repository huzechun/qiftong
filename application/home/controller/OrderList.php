<?php namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Session;


class OrderList extends Controller{

    //支付页面订单信息

    public function order_info(){

        if(request()->isPost()){

            $order_no = input('post.new_no');

            $order_data = Db::name('order_list')

                ->field("member_id, order_no , project_name , num , city , total_price ")

                ->where (['order_no' => $order_no , 'status' => 1])

                ->select();

            //dump($order_data);
        }

         return ['order_data' => $order_data];
    }


    //个人中心订单信息
    public function order_list()
    {

        if (!Session::has('user')) {

            return ['code' => 400, 'msg' => '请先登录'];

        } else {

            $user = Session::get('user');

            $mid = $user['id'] ;

            //$where = is_null(input('post.paystatus')) ? "" : ['paystatus' => input('post.paystatus')];

            $dh = Db::name('order_list')->distinct(true)->field('order_no, order_time, paystatus')

                ->where(['member_id' =>$mid]) -> order('order_time desc')->select();


            $new_arr = [];

            foreach($dh as $k => $v) {

                $is_comment = Db::name('order_list')->field('order_no , is_comment')->where(['order_no' => $v['order_no']])->select();

                $arr = [];

                foreach ($is_comment as $item => $value) {

                    $arr = array_merge_recursive($arr, $value);

                }

                if (sizeof($arr, 1) > 2) {

                    if (in_array(1, $arr['is_comment'])) {

                        $arr['is_comment'] = 1;
                        $arr['order_no'] = $arr['order_no'][0];

                    }else{

                        $arr['is_comment'] = 0;
                        $arr['order_no'] = $arr['order_no'][0];
                    }
                }

                $new_arr[] = $arr;

            }

            //print_r($new_arr);

            $order_data = [];

            foreach ($dh as $k => $v) {

                $order_data[$v['order_no']]['order_data'] = Db::name('order_list')

                    ->distinct(true)->field('order_time')

                    ->field(" member_id,  project_id , project_name, price , num , city ,paystatus, total_price ")

                    ->where('order_no', $v['order_no'])

                    ->order('order_time desc')

                    ->select();

                $order_data[$v['order_no']]['order_time'] = $v['order_time'];

                $order_data[$v['order_no']]['paystatus']  = $v['paystatus'];

                $order_data[$v['order_no']]['order_no']  = $v['order_no'];


                foreach ($new_arr as $item=>$value){

                    if($v['order_no'] == $value['order_no']){

                        $order_data[$v['order_no']]['is_comment'] = $value['is_comment'];
                    }

                }

            }


            $this->assign('order_data', $order_data);  //全部订单

            return view();

        }
    }


    //待付款

    public function not_payment(){

        if (!Session::has('user')) {

            return ['code' => 400, 'msg' => '请先登录'];

        } else {

            $user =  Session::get('user');

            $mid  =  $user['id'];

            $dh0 = Db::name('order_list')->distinct(true)->field('order_no, order_time, paystatus')

                ->where(['member_id' => $mid, 'paystatus' => 0])->order('order_time desc')->select();

            //  未付款

            $order_data0 = [];

            foreach ($dh0 as $k => $v) {

                $order_data0[$v['order_no']]['order_data0'] = Db::name('order_list')
                    ->distinct(true)->field('order_time')
                    ->field(" member_id,  project_id , project_name, price , num , paystatus,city , total_price ")
                    ->where('order_no', $v['order_no'])
                    ->order('order_time desc')
                    ->select();

                $order_data0[$v['order_no']]['order_time'] = $v['order_time'];

                $order_data0[$v['order_no']]['paystatus'] = $v['paystatus'];

                $order_data0[$v['order_no']]['order_no'] = $v['order_no'];

            }

        }

        //dump($order_data0) ;

        $this->assign('order_data0', $order_data0); //已付款

        return view();
    }


    ////已付款

    public function paid(){

      /*  if (!Session::has('user')) {

                   return ['code' => 400, 'msg' => '请先登录'];

               } else {*/

            $user =  Session::get('user');

            $mid  =  $user['id'];

            $dh1 = Db::name('order_list')->distinct(true)->field('order_no, order_time, paystatus')

                ->where(['member_id' => $mid, 'paystatus' => 1])->order('order_time desc')->select();

             //dump($dh1);

            $new_arr1 = [];

            foreach ($dh1 as $k => $v) {

                $is_comment = Db::name('order_list')->field('order_no , is_comment')
                    ->where(['order_no' => $v['order_no']])->order('order_time desc')->select();

                $arr1 = [];

                foreach ($is_comment as $item => $value) {

                    $arr1 = array_merge_recursive($arr1, $value);

                }

               // dump($arr1);

                if (sizeof($arr1, 1) > 2) {

                    if (in_array(1, $arr1['is_comment'])) {

                        $arr1['is_comment'] = 1;
                        $arr1['order_no'] = $arr1['order_no'][0];

                    } else {

                        $arr1['is_comment'] = 0;
                        $arr1['order_no'] = $arr1['order_no'][0];
                    }
                }

                $new_arr1[] = $arr1;

            }


            $order_data1 = [];

            foreach ($dh1 as $k => $v) {

                $order_data1[$v['order_no']]['order_data1'] = Db::name('order_list')
                    ->distinct(true)->field('order_time')
                    ->field(" member_id,  project_id , project_name, price , num , paystatus, city , total_price ")
                    ->where('order_no', $v['order_no'])
                    ->order('order_time desc')
                    ->select();

                $order_data1[$v['order_no']]['order_time'] = $v['order_time'];

                $order_data1[$v['order_no']]['paystatus'] = $v['paystatus'];

                $order_data1[$v['order_no']]['order_no'] = $v['order_no'];

                foreach ($new_arr1 as $item => $value) {

                    if ($v['order_no'] == $value['order_no']) {

                        $order_data1[$v['order_no']]['is_comment'] = $value['is_comment'];
                    }
                }
            }

            //return ['paid'=> $order_data1 ];

            //dump($order_data1);

            $this->assign('order_data1', $order_data1); //已付款

            return view();
        //}
}


    //添加订单信息

    public function add_order(){

        //return view();

        if (request()->isPost()) {

            $user = Session::get('user');

            $member_id = $user['id'];

            $cart_data = Db::name('cart')->where(['member_id' => $member_id , 'status' => 1])->select();

            //trace('记录',json_encode($cart_data));

            $order_no = "DD" . date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            $or_data = [];

            foreach ($cart_data as $k => $v) {

                $or_data[$k]['member_id'] = $member_id;
                $or_data[$k]['project_id'] = $v['project_id'];
                $or_data[$k]['project_name'] = $v['project_name'];
                $or_data[$k]['price'] = $v['price'];
                $or_data[$k]['total_price'] = $v['total'];
                $or_data[$k]['num'] = $v['num'];
                $or_data[$k]['cart_no'] = $v['cart_no'];
                $or_data[$k]['order_time'] = time();
                $or_data[$k]['order_no'] = $order_no;

            }

            $order = new \app\home\model\OrderList();

            $order->saveAll($or_data);

            //dump($or_data);

            $update_status = Db::name('cart')->where(['member_id' => $member_id])->update(['status' => 0]);

            if ($update_status) {

                    Session::set('cart_num', 0);

                    //返回页面信息

                    $order_data = [];

                    foreach($or_data as $k => $v){

                        $order_data[$k]['new_no']             =  $or_data[$k]['order_no'];

                        $order_data[$k]['new_project_name']   =  $or_data[$k]['project_name'];

                        $order_data[$k]['new_num']            =  $or_data[$k]['num'];

                    }

                    $amount = Db::name('order_list') ->where('order_no',$order_data[0]['new_no']) ->sum('total_price');

                      $this->assign('order_data' , $order_data[0]['new_no'] );

                      $this->assign('amount',$amount);

                      return view();

            }else{

                   return ['code'=>400,'msg'=>'添加失败'];
                 }
            }
    }
    

    //取消订单
    public function del_order(){

        if(request()->isPost()){

            $order_no = input('post.order_no');

            $del_data = Db::name('order_list')

                ->where('order_no',$order_no)

                ->delete();
        }

        if($del_data){

            return ['code'=>200,'msg'=>'取消成功'];

        }else{

            return ['code'=>400,'msg'=>'取消失敗'];

        }

    }

    //申请发票信息

    public function invoice(){

        if(request()->isPost()){

            $order_no = input('post.order_no') ;

            $invoice = Db::name('invoice') ->where('order_no' , $order_no) ->select();

            if($invoice){

                return ['code'=>400,'msg'=>'您已经申请过开票' ];

            }else{

                $mid = Session::get('id.user');

                $total_amount = Db::name('order_list') ->where('order_no' , $order_no) ->sum('total_price');

                $data = $_POST;

                $data['pay_unit']          = $_POST['pay_unit'] ;
                $data['all_amount']        = $total_amount ;
                $data['order_no']          = $order_no ;
                $data['mobilephone']       = $_POST['mobilephone'] ;
                $data['invoice_address']   = $_POST['invoice_address'] ;
                $data['member_id']         = $mid ;
                $data['invoice_time']      = time();

                $insert = Db::name('invoice') -> insert($data) ;

                if($insert)  return ['code'=>200,'msg'=>'申请成功' ];

                else         return ['code'=>400,'msg'=>'申请失败'];

            }
        }

        return view();
    }


        // 会员发票信息

        public function bill(){

            $user = Session::get('user');

            $mid = $user['id'] ;


            $data =  Db::name('invoice')

                ->field("pay_unit , mobilephone , all_amount , order_no , invoice_address ,  is_open,invoice_time,member_id")

                ->where(['member_id' => $mid]) ->select() ;


            $this->assign('data',$data);

            return view() ;


        }

}