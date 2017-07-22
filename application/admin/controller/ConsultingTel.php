<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);

use app\admin\Controller;
use think\Db;
class ConsultingTel extends Controller
{
    use \app\admin\traits\controller\Controller;
    // 方法黑名单
    protected static $blacklist = [];



    public function beforeIndex(){
      $data = Db::name('Consulting_type')->select();
      $view = $this->view;
      $view->data  =  $data;
      // 模板输出
    return view();
    }


}
