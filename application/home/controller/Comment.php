<?php namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Session;

class Comment extends Controller{

    // 评价管理内容显示
    public function comment_content($order_no){

        $user = Session::get('user');

        $mid = $user['id'] ;

        $comment_data = Db::name('order_list') ->where(['order_no'=> $order_no ,  'is_comment' => 0,'member_id'=> $mid]) ->select();

        $tag  =  Db::name('tag') ->select();

        $this->assign("comment_data" , $comment_data);

        $this->assign("tag" , $tag);

        return view();
    }


    //会员评价

    public function comment(){

        if(request()->isPost()){


            $user = Session::get('user');

            $mid = $user['id'] ;


            $data = $_POST;

            $id =  $_POST['id'] ;

            //评论时若没有选择标签则随机选取
            $max_id = Db::name('tag') ->max('id');

            $rand_tag = mt_rand(1,$max_id) ;

            $tag_data = empty($_POST['tag_id']) ? [$rand_tag] : $_POST['tag_id'] ;

            $tag_id = implode(',',$tag_data) ;


             $data['tag_id']            = $tag_id;
             $data['project_id']        = $_POST['project_id'] ;
             $data['project_name']      = $_POST['project_name'] ;
             $data['order_list_id']     = $id ;
             $data['member_id']         = $mid ;
             $data['star']              = empty($_POST['star']) ? 5 : empty($_POST['star'])  ; //默认五星好评
             $data['comment_time']      = time();


            Db::name('comment') ->insert($data) ;

            // 修改评论状态
            $com = Db::name('order_list') -> where('id' , $id) ->update(['is_comment' => 1]) ;

            $no  = Db::name('order_list') -> where('id' , $id) ->column('order_no') ;

             //存在多条评论
            $status  = Db::name('order_list') -> where('order_no' ,'in',  $no) ->column('is_comment') ;

            if($com){

                if(in_array(0, $status)){

                    return ['code'=> 200 , 'msg' => '评论成功','jump'=>0] ;

                }else{

                    return ['code'=> 200 , 'msg' => '评论成功' , 'jump' => 1] ;
                }

            } else{

                return ['code'=> 400 , 'msg' => '评论失败'] ;
            }

        }

    }
}