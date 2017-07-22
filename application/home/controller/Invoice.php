<?php namespace app\home\controller;



use think\Controller;
use think\Db;
use think\Session;

class Invoice extends Controller{

    public function invoice(){

        if(request()->isPost()){

            $order_no = input('post.order_no') ;

            $invoice = Db::name('invoice') ->where('order_no' , $order_no) ->select();

            if($invoice){

                return ['code'=>400,'msg'=>'您已经申请过开票' ];

            }else{

                $user = Session::get('user');

                $mid = $user['id'] ;

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


    public function show_invoice(){

        $user = Session::get('user');
        $mid = $user['id'] ;

        $data =  Db::name('invoice') ->where(['member_id' => $mid]) ->select() ;

        $this->assign('data',$data);

        return view() ;


    }

}
