<?php

namespace app\index\model;

use think\Model;

class RoleAccess extends Model
{
    protected $insert = ['created_time'];

    protected function setCreatedTimeAttr()
    {
        return date('Y:m:d H:i:s',time());
    }
}
