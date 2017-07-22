<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);

use app\admin\Controller;
use think\Db;
class ConsultingContent extends Controller
{
    use \app\admin\traits\controller\Controller;
    // 方法黑名单
    protected static $blacklist = [];

  
    public function beforeIndex(){
        $data = Db::name('consulting_type')->field('id,consulting_type_title')->select();
        $view = $this->view;
        $view->data  =  $data;
        // 模板输出
      return view('form');
    }


    public function beforeRecyclebin(){
        $data = Db::name('consulting_type')->field('id,consulting_type_title')->select();
        $view = $this->view;
        $view->data  =  $data;
        // 模板输出
      return view('recyclebin');
    }

    public function beforeEdit(){
        $data = Db::name('consulting_type')->field('id,consulting_type_title')->select();
        $view = $this->view;
        $view->data  =  $data;
        // 模板输出
      return view('edit');
    }

    public function beforeAdd(){
        $data = Db::name('consulting_type')->field('id,consulting_type_title')->select();
        $view = $this->view;
        $view->data  =  $data;
        // 模板输出
      return view('add');
    }


}
