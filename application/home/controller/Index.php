<?php namespace app\home\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    //首页目录显示
    public function index(){

        //首页服务推荐

        $data = Db::name('service_recommendation')->where('status' ,1)->select();
        //dump($data);

        //return ajax_return($data);


        $map['id']=['neq',6];
        $map['isshow']=['neq',0];

       $cate =  Db::name('consulting_type') ->where($map) ->select();
        
        foreach ($cate as $k=>$v){

            $cate[$k]['project_content'] =  Db::name('consulting_content') ->where(['consulting_type_id' => $cate[$k]['id'] ]) ->select();

        }


        //开始

        /*//顶级分类数据

        $catedata = Db::name('service_category')->where('service_category_parentid = 0')->select();

        //二级分类数据

        foreach ($catedata as $k => $v) {

            $catedata[$k]['sub1'] = Db::name('service_category')

                ->where(['service_category_parentid' => $v['id'],'status'=>1])

                ->select();
        }


        //dump($catedata);exit;

        //分类数据合并

        foreach ($catedata as $k => $v) {

            $sub2 = [];

            foreach ($v['sub1'] as $key => $value) {

                $res = Db::name('service_project')

                    ->where(['parent_id' => $value['id']])

                    ->select();

                $value['sub2'] = $res;

                $sub2[] = $value;
            }

            $v['sub1'] = $sub2;

            $catedata[$k]['sub1']= $v['sub1'];
        }*/

        //dump($catedata) ;

        //return ajax_return($catedata,'success',200);

       // $this->assign('catedata' , $catedata) ;


        //结束


       //dump($cate);

        $this->assign('cate' , $cate);

        $this->assign('data' , $data);

        return view('index');
    }


    public function index2()
    {
        //顶级分类数据

        $catedata = Db::name('service_category')->where('service_category_parentid = 0')->select();

        //二级分类数据

        foreach ($catedata as $k => $v) {

            $catedata[$k]['sub1'] = Db::name('service_category')

                ->where(['service_category_parentid' => $v['id'],'status'=>1])

                ->select();
        }


        //dump($catedata);exit;

        //分类数据合并

        foreach ($catedata as $k => $v) {

            $sub2 = [];

            foreach ($v['sub1'] as $key => $value) {

                $res = Db::name('service_project')

                    ->where(['parent_id' => $value['id']])

                    ->select();

                $value['sub2'] = $res;

                $sub2[] = $value;
            }

            $v['sub1'] = $sub2;

            $catedata[$k]['sub1']= $v['sub1'];
        }

        //dump($catedata) ;

        return ajax_return($catedata,'success',200);

        //$this->assign('catedata' , $catedata) ;

          //return view();
    }


     //首页合作伙伴

    public function partner(){

        $data = Db::name('partner')->select();

        //return view();

        return ajax_return($data);
    }

  /*  //关于企服通
    public function about(){

        $about = Db::name('about')->find();

        $this->assign('about',$about);

        return view();

         //return ajax_return($about);

        //return ['about' => $about];
        
    }*/

    //关于我们

    public function about(){

        $data = Db::name('link_content')->where('id' , 1) ->select();

        $about = [];

        foreach($data as $k=>$v){

            $about['detail_title']       = $v['detail_title'];
            $about['detail_pic']         = $v['detail_pic'];
            $about['detail_description'] = strip_tags(htmlspecialchars_decode($v['detail_description']));
        }

        $this->assign('about' , $about) ;

        return view();

    }

    //加入我们
    public function joinus(){

        $data =  Db::name('link_content')->where('id' , 2) ->select();

       // dump($data);

        $joinus = [] ;

        foreach($data as $k=>$v){

            $joinus['detail_title']       = $v['detail_title'];
            $joinus['detail_pic']         = $v['detail_pic'];
            $joinus['detail_description'] = htmlspecialchars_decode($v['detail_description']);
        }

        //dump($joinus);

        $this->assign('joinus' , $joinus) ;

        return view();

    }

    //友情链接
    public function links(){

        $data = Db::name('link_content')->where('id' , 4) ->select();

        $links = [];

        foreach($data as $k=>$v){

            $links['detail_title']       = $v['detail_title'];
            $links['detail_pic']         = $v['detail_pic'];
            $links['detail_description'] = htmlspecialchars_decode($v['detail_description']);
        }

        $this->assign('links' , $links) ;

        return view();

    }

    //联系我们
    public function attach_us(){

        $data = Db::name('contact')->select();

        $this->assign('data' , $data) ;

        return view();

    }

    //商务合作
    public function cooperation(){

        $data = Db::name('link_content')->where('id' , 3) ->select();

        $cooperation = [];

        foreach($data as $k=>$v){

            $cooperation['detail_title']       = $v['detail_title'];
            $cooperation['detail_pic']         = $v['detail_pic'];
            $cooperation['detail_description'] =  strip_tags(html_entity_decode($v['detail_description']));

        }
        

        $this->assign('cooperation' , $cooperation) ;

        return view();
    }

    //孵化器
    public function incubator(){

        $data = Db::name('incubator') -> select();

        $this->assign('data' , $data) ;

        return view();
    }


    //服务商列表
    public function provider(){

        $provider = Db::name('provider')->select();

        $this->assign('provider',$provider);

        //return view();

        return ajax_return($provider);
    }


    // 横轴导航栏更多服务
    public function more_service(){

        $map['id']=['neq',6];

        $cate =  Db::name('consulting_type') ->where($map)  ->select();

        foreach ($cate as $k=>$v){

            $cate[$k]['project_content'] =  Db::name('consulting_content') ->where(['consulting_type_id' => $cate[$k]['id'] ]) ->select();

        }

        //dump($cate);

        $this->assign('cate' , $cate);

        return view();

    }



}

