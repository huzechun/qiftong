<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);

use app\admin\Controller;
use think\Db;
class ServiceProject extends Controller
{
    use \app\admin\traits\controller\Controller;
    // 方法黑名单
    protected static $blacklist = [];

    protected function filter(&$map)
    {
        if ($this->request->param("project_name")) {
            $map['project_name'] = ["like", "%" . $this->request->param("project_name") . "%"];
        }
    }


    public function beforeAdd(){
      $data = Db::name('ServiceCategory')->where('service_category_parentid',0)->select();
      $view = $this->view;
      $view ->data = $data;
      return view('add');
    }

    public function beforeEdit(){
      $data = Db::name('ServiceCategory')->where('service_category_parentid',0)->select();
      $view = $this->view;
      $view ->data = $data;
      return view('edit');
    }

    public function beforeIndex(){
      $data = Db::name('ServiceCategory')->where('service_category_parentid',0)->select();
      $view = $this->view;
      $view ->data = $data;
      return view('form');
    }
}
