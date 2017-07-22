<?php

namespace app\home\controller;

use think\Controller;
use think\Db;

class ProjectContent extends Controller{


    //点击二级名称内容显示

    public function second_category(){

        $cid = input('post.service_category_id');

        $content_data = Db::name('service_category')->alias('sc')

            ->field('sc.service_category_name,sp.id,sp.project_name,
            
                     sp.price,sp.old_price,sp.sort,sp.project_description,sp.project_pic,
                     
                     sp.project_safeguards,sp.project_banner,sp.service_introduction')

            ->join('service_project sp','sp.parent_id = sc.id')

            ->where('sc.id',$cid)

            ->order('sp.sort,sc.sort')

            ->limit(1)

            ->select();

        return ['content_data'=>$content_data];
    }



    //服务推荐点击具体项目内容显示

    public function project_content($id){

        $pt_id = $id;

        $data = Db::name('service_project')

              ->where('id',$pt_id)

              ->find();
        //dump($data);


    /***
     *
     *    项目详情页汇总部分
     *
     */


        //好评率

           $rate = Db::name('comment')->field('comment_content')

               ->where('project_id',$pt_id)->column('star');

           //所有评价
           $count_rate = $rate;

           $rate = array_count_values($rate);

              array_key_exists(0, $rate) ? $rate[0] : $rate[0]=0 ;
              array_key_exists(1, $rate) ? $rate[1] : $rate[1]=0 ;
              array_key_exists(2, $rate) ? $rate[2] : $rate[2]=0 ;
              array_key_exists(3, $rate) ? $rate[3] : $rate[3]=0 ;
              array_key_exists(4, $rate) ? $rate[4] : $rate[4]=0 ;
              array_key_exists(5, $rate) ? $rate[5] : $rate[5]=0 ;

           $new = 0;

           foreach ($rate as $k=>$v){

               $new = $new +$v;

           }

              $new_data =[

                'ALL' => count($count_rate),
                'HP'  => $new == 0 ? (0 .'%') : round((($rate[5] + $rate[0]) / $new),2) * 100 . '%',
                'ZP'  => $new == 0 ? (0 .'%') : round((($rate[4] + $rate[3]) / $new),2) * 100 . '%',
                'CP'  => $new == 0 ? (0 .'%') : round((($rate[2] + $rate[1]) / $new),2) * 100 . '%',

              ];

        /*
         *     评价内容部分
         *
         */


            //所有评论
        $all_data = Db::name('comment')->alias('c')

                ->field(['c.project_id', 'm.mobilephone', 'c.project_name' , 'c.comment_time' , 'c.comment_content' , 'c.star'])

                ->join('order_list ol', 'c.order_list_id = ol.id')

                ->join('member m', 'm.id = c.member_id')

                ->where('c.project_id', $pt_id)

                ->order('c.comment_time desc')

                //->paginate(5);

                ->select();

                $cm_data = [] ;
                foreach($all_data as $k=>$v){

                    $cm_data[$k]['project_id']       = $all_data[$k]['project_id'] ;
                    $cm_data[$k]['mobilephone']      = substr_replace($all_data[$k]['mobilephone'],'****',3,4) ;
                    $cm_data[$k]['project_name']     = $all_data[$k]['project_name'] ;
                    $cm_data[$k]['comment_time']     = date('Y.m.d',$all_data[$k]['comment_time']) ;
                    $cm_data[$k]['comment_content']  = $all_data[$k]['comment_content'] ;
                    $cm_data[$k]['star']             = $all_data[$k]['star'] ;
                }
           


            //好评

        $praise_data = Db::name('comment')->alias('c')

                ->field(['ol.project_id', 'm.mobilephone', 'ol.project_name' , 'c.comment_time '=>'comment_time' , 'c.comment_content' , 'c.star'])

                ->join('order_list ol', 'c.order_list_id = ol.id')

                ->join('member m', 'm.id = c.member_id')

                ->where('c.project_id', $pt_id)

                ->where('star',['=',5] , ['exp', 'is null'], 'or')

                ->order('c.comment_time desc')

                ->select();

             $praise = [] ;

            foreach($praise_data as $k=>$v){

                $praise[$k]['project_id']       = $praise_data[$k]['project_id'] ;
                $praise[$k]['mobilephone']      = substr_replace($praise_data[$k]['mobilephone'],'****',3,4) ;
                $praise[$k]['project_name']     = $praise_data[$k]['project_name'] ;
                $praise[$k]['comment_time']     = date('Y.m.d',$praise_data[$k]['comment_time']) ;
                $praise[$k]['comment_content']  = $praise_data[$k]['comment_content'] ;
                $praise[$k]['star']             = $praise_data[$k]['star'] ;
            }

            //中评


            $common_data = Db::name('comment')->alias('c')

                ->field(['ol.project_id', 'm.mobilephone', 'ol.project_name' , 'comment_time' , 'c.comment_content' , 'c.star'])

                ->join('order_list ol', 'c.order_list_id = ol.id')

                ->join('member m', 'm.id = c.member_id')

                ->where('c.project_id', $pt_id)

                ->where('star',['=',3],['=',4],'or')

                ->order('c.comment_time desc')

                ->select();

                $common = [] ;

                foreach($common_data as $k=>$v){

                    $common[$k]['project_id']       = $common_data[$k]['project_id'] ;
                    $common[$k]['mobilephone']      = substr_replace($common_data[$k]['mobilephone'],'****',3,4) ;
                    $common[$k]['project_name']     = $common_data[$k]['project_name'] ;
                    $common[$k]['comment_time']     = date('Y.m.d',$common_data[$k]['comment_time']) ;
                    $common[$k]['comment_content']  = $common_data[$k]['comment_content'] ;
                    $common[$k]['star']             = $common_data[$k]['star'] ;
                }


            //差评

            $bad_data = Db::name('comment')->alias('c')

                ->field(['ol.project_id', 'INSERT(m.mobilephone,4,4,"****")'=> 'mobilephone', 'ol.project_name' , 'FROM_UNIXTIME(c.comment_time ,\'%Y-%m-%d\')'=>'comment_time' , 'c.comment_content' , 'c.star'])

                ->join('order_list ol', 'c.order_list_id = ol.id')

                ->join('member m', 'm.id = c.member_id')

                ->where('c.project_id', $pt_id)

                ->where('star',['=',1],['=',2],'or')

                ->order('c.comment_time desc')

                ->select();

                $bad = [] ;

                foreach($bad_data as $k=>$v){

                    $bad[$k]['project_id']       = $bad_data[$k]['project_id'] ;
                    $bad[$k]['mobilephone']      = substr_replace($bad_data[$k]['mobilephone'],'****',3,4) ;
                    $bad[$k]['project_name']     = $bad_data[$k]['project_name'] ;
                    $bad[$k]['comment_time']     = date('Y.m.d',$bad_data[$k]['comment_time']) ;
                    $bad[$k]['comment_content']  = $bad_data[$k]['comment_content'] ;
                    $bad[$k]['star']             = $bad_data[$k]['star'] ;
                }


            //项目印象标签

            $tid = Db::name('comment')->field(['group_concat(tag_id)' =>'tag_id']) ->where('project_id' , $pt_id) -> find();

            $tid_data = explode(',' , implode(',', $tid));


            $tname_data = Db::name('tag') ->field('id , tag_name') ->select();


            $new_tag =[];
        
            foreach($tid_data as $k => $v){

                foreach($tname_data as $tk => $tv){

                    if($v == $tname_data[$tk]['id']){

                        $new_tag[] = $tname_data[$tk]['tag_name'];
                    }
                }
            }


            $tag_data = array_count_values($new_tag);


            //热门问答Title

            $qa_title = Db::name('hot_quiz')->distinct(true)->field('type_title')->select();


           //热门问答内容

            $tid = empty($_POST['type_id']) ?  '' :['type_id'=>$_POST['type_id']]  ;

            $qa_content = Db::name('hot_quiz')->where(['project_id'=>$id ,'isdelete'=>0])->where($tid)->select();

           //关于企服通

             $about = Db::name('about')->where('isdelete' ,0)->find();


           // 供应商信息

            $provider = Db::name('provider') ->where('isdelete' ,0) ->select();

             //服务保障

             $guarantee = Db::name('service_guarantee') ->where('isdelete' ,0) ->select();
        

            //点击具体项目内容显示
            $this->assign('data',$data);

            //好评率百分比和评价总数
            $this->assign('new_data',$new_data);

            //全部评价内容
            $this->assign('cm_data',$cm_data);

            //好评内容
            $this->assign('praise', $praise);

            //中评内容
            $this->assign('common', $common);

            //差评内容
            $this->assign('bad', $bad);

            //项目印象标签
            $this->assign('tag_data', $tag_data);

            //热门问答
            $this->assign('qa_content',$qa_content);

            //关于企服通
            $this->assign('about',$about);

            // 供应商
            $this->assign('provider' , $provider);

           // 服务保障
            $this->assign('guarantee' , $guarantee);


        return view();

    }



}