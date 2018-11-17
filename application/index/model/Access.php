<?php

namespace app\index\model;

use think\Model;

class Access extends Model
{
    protected $auto = ['updated_time'];
    protected $insert = ['created_time'];

    protected function setCreatedTimeAttr()
    {
        return date('Y:m:d H:i:s',time());
    }

    protected function setUpdatedTimeAttr()
    {
        return date('Y:m:d H:i:s',time());
    }
}
