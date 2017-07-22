<?php namespace app\home\controller;

use think\Controller;
use think\Db;

class ConsultingContent extends Controller{

    //服务咨询类别列表
    public function consulting_content(){

        $ctid = input('post.consulting_type_id');

        $showcount = input('post.showcount');

        $data = Db::name('consulting_type')->alias('ct')
            ->field('ct.consulting_type_id, ct.consulting_type_title,cct.consulting_content_id,cct.project_id,
                      cct.detail_logo,cct.detail_description,cct.detail_title,cct.detail_price,cct.detail_tel,cct.sort')
            ->join('consulting_content cct','ct.consulting_type_id = cct.consulting_type_id')
            ->where('ct.consulting_type_id',$ctid)
            ->order('cct.sort')
            ->limit($showcount)
            ->select();

        return ajax_return(['data'=>$data]);

    }
    
    //保存客户咨询预留电话
    public function consulting_tel(){

        if(request()->isPost()) {

            $cc_id = input('post.consulting_content_id');

            $data = [

                'consulting_content_id' => $cc_id,
                'member_id' => input('post.member_id'),
                'project_id' => input('post.project_id'),
                'customer_tel' => input('post.customer_tel'),
                'consulting_time' => time(),
            ];

            $db = Db::name('consulting_tel')->insert($data);

            if ($db) return ['code' => 200, 'msg' => '提交成功!稍后服务人员将与您联系'];

            else return ['code' => 400, 'msg' => '提交失败'];

        }

    }

    /*//首页服务推荐
    public function service_recommendation(){

        $data = Db::name('service_recommendation')->where('status' ,1)->select();

        dump($data);

        return ajax_return($data);
    }*/

    //首页服务推荐
    public function service_recommendation(){

        $data = Db::name('service_recommendation')->where('status' ,1)->select();

        dump($data);

        return ajax_return($data);
    }



    //首页办公选址
    public function office_address(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',7)
            ->order('sort')
            //->limit (8)
            ->select();
        //return view();
        return ajax_return($data);
    }

    //首页金融服务
    public function finance(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',8)
            ->order('sort')
            //->limit (8)
            ->select();

        //return view();
        return ajax_return($data);
    }

    //更多服务模板加载
    public function more_service($id)
    {

        $title = Db::name('consulting_type')->where('id',$id)->value('consulting_type_title');

        $more = Db::name('consulting_content') -> where('consulting_type_id' , $id) ->select();

        $more_data = ['title'=>$title,'data'=>$more];

        $this->assign('more_data' , $more_data) ;

        return view();
    }


    //更多服务投资机构5条
    public function investment(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',9)
            ->order('sort')
            //->limit (4)
            ->select();
        //return view();
        return ajax_return($data);
    }

    //更多服务团队协作5条
    public function teamwork(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',10)
            ->order('sort')
            //->limit (5)
            ->select();

        //return view();
        return ajax_return($data);
    }

    //更多服务云服务
    public function cloud_service(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',11)
            ->order('sort')
            //->limit (8)
            ->select();
        //return view();
        return ajax_return($data);
    }

    //更多服务建站营销
    public function station(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',12)
            ->order('sort')
            //->limit (8)
            ->select();
        //return view();
        return ajax_return($data);
    }

    //更多服务设计印刷
    public function printing(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',13)
            ->order('sort')
            //->limit (4)
            ->select();
        //return view();
        return ajax_return($data);
    }

    //更多服务装修绿植
    public function decorate(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',14)
            ->order('sort')
            //->limit (4)
            ->select();

        //return view();
        return ajax_return($data);
    }

    //更多服务技术开发
    public function technology(){
        $data = Db::name('consulting_content')
            ->where('consulting_type_id',15)
            ->order('sort')
            //->limit (4)
            ->select();

        //return view();
        return ajax_return($data);
    }

     //更多服务其他服务
    public function other_service(){

        $data = Db::name('consulting_content')
            ->where('consulting_type_id',16)
            ->order('sort')
            //->limit (4)
            ->select();

        return ajax_return($data);

    }




}