<?php


//------------------------
// 登录日志模型
//-------------------------

namespace app\common\model;

use think\Model;

class LoginLog extends Model
{
    public function user()
    {
        return $this->hasOne('AdminUser', "id", "uid", ["id" => "uuid"]);
    }
}
