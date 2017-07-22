<?php


namespace app\home\controller;


use app\home\model\Region as regionModel;
use think\Controller;

class City extends Controller
{
        /**
         * 城市三级联动
         * @return array|mixed
         */
        public function index()
        {
            if (request()->isPost()) {
                $regionModel = new regionModel();
                $type = input('post.type');
                $parent = input('post.parent');
                $province = $regionModel->region($type, $parent);
                $position = $regionModel->position();
                return ['province' => $province, 'position' => $position];
            }

//            return $this->fetch();

            return view();
        }

        /**
         * 市
         * @return array
         */
        public function searchCity()
        {
            if (request()->isPost()) {
                $regionModel = new regionModel();
                $id = input('post.id');
                $city = $regionModel->searchCity($id);
                return ['city' => $city];
            }
            return ['error' => '异常错误'];
        }

        /**
         * 县
         * @return array
         */
        public function searchCounty()
        {
            if (request()->isPost()) {
                $regionModel = new regionModel();
                $id = input('post.id');
                $county = $regionModel->searchCounty($id);
                return ['county' => $county];
            }
            return ['error' => '异常错误'];
        }

        /**
         * 乡镇
         * @return array
         */
        public function searchTown()
        {
            if (request()->isPost()) {
                $regionModel = new regionModel();
                $id = input('post.id');
                $town = $regionModel->searchTown($id);
                return ['town' => $town];
            }
            return ['error' => '异常错误'];
        }

        /**
         * 村庄
         * @return array
         */
        public function searchVillage()
        {
            if (request()->isPost()) {
                $regionModel = new regionModel();
                $id = input('post.id');
                $village = $regionModel->searchVillage($id);
                return ['village' => $village];
            }
            return ['error' => '异常错误'];
        }
}