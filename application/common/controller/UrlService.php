<?php

namespace app\common\controller;

use think\Controller;

class UrlService extends Controller
{
    public static function buildUrl($uri, $params=[])
    {
        return url($uri,$params);
    }

    public static function buildNullUrl()
    {
        return "javascript:void(0);";
    }
}
