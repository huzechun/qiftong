<?php namespace app\home\controller;


use app\admin\Controller;
use think\Db;

class LinkContent extends Controller{

    public function link_content(){

        $lid = input('post.id');

        $link_data = Db::name('link_content') ->where('id',$lid) ->find();

        $this->assign('link_data',$link_data);

    }


}