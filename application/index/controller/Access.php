<?php

namespace app\index\controller;

class Access extends Common
{
    public function index() {
        $access_list = \app\index\model\Access::where('status',1)->order('id','desc')->select();
        $this->assign('list',$access_list);
        return $this->fetch();
    }


    public function set()
    {
        if (request()->isGet()) {
            $id = input('param.id', 0);
            $info = [];
            if ($id) {
                $info = \app\index\model\Access::where('id', $id)->where('status',1)->find();
            }
            $this->assign('info', $info);
            return $this->fetch();
        }

        $id = input('post.id','');
        $title = input('post.title','');
        $urls = input('post.urls','');

        if( mb_strlen($title,"utf-8") < 1 || mb_strlen($title,"utf-8") > 20 ){
            return json(['msg' => '请输入合法的权限标题', 'code' => -1]);
        }

        if( !$urls ){
            return json(['msg' => '请输入合法的Urls', 'code' => -1]);
        }

        $urls = explode("\n",$urls);
        if( !$urls ){
            return json(['msg' => '请输入合法的Urls', 'code' => -1]);
        }

        $has_in = \app\index\model\Access::where('title',$title)->where('id','<>',$id)->find();
        if( $has_in ){
            return json(['msg' => '该权限标题已存在', 'code' => -1]);
        }

        $info = \app\index\model\Access::where('id', $id)->find();

        if ($info) {
            //编辑
            \app\index\model\Access::update([
                'id' => $id,
                'title' => $title,
                'urls' => json_encode($urls)
            ]);
        } else {
            //添加
            \app\index\model\Access::create([
                'title' => $title,
                'urls' => json_encode($urls)
            ]);
        }

        return ['msg' => '添加成功', 'code' => 200];


    }
}
