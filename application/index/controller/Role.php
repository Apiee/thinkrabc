<?php

namespace app\index\controller;

use app\index\model\RoleAccess;
use think\Controller;

class Role extends Common
{
    public function index()
    {
        $roleRes = \app\index\model\Role::order('id', 'desc')->paginate(2);
        $this->assign('roleres', $roleRes);
        return $this->fetch();
    }

    public function set()
    {
        if (request()->isGet()) {
            $id = input('param.id', 0);
            $info = [];
            if ($id) {
                $info = \app\index\model\Role::where('id', $id)->find();
            }
            $this->assign('info', $info);
            return $this->fetch();
        }

        $name = input('post.name');
        $id = input('post.id');
        if (!$name) {
            return json(['msg' => '请输入合法的名称', 'code' => -1]);
        }

        $roleInfo = \app\index\model\Role::where('name', $name)->where('id', '<>', $id)->find();

        if ($roleInfo) {
            return ['msg' => '该角色已经存在', 'code' => -1];
        }

        $info = \app\index\model\Role::where('id', $id)->find();

        if ($info) {
            //编辑
            \app\index\model\Role::update([
                'id' => $id,
                'name' => $name
            ]);
        } else {
            //添加
            \app\index\model\Role::create([
                'name' => $name
            ]);
        }

//        $role = new\app\index\model\Role();
//        $role->name = $name;
//        $role->save();
        return ['msg' => '添加成功', 'code' => 200];
    }

    public function access()
    {
        if (request()->isGet()) {
            $id = input('param.id', 0);
            $info = \app\index\model\Role::where('id', $id)->find();
            if (!$info) {
                $this->redirect("index/role/index");
            }

            //取出所有权限
            $access_list = \app\index\model\Access::where('status',1)->order('id','desc')->select();

            //取出已分配的权限
            $role_access_id =  RoleAccess::where('role_id',$id)->column('access_id');

            $this->assign('role_access_id',$role_access_id);
            $this->assign('access_list',$access_list);
            $this->assign('info',$info);
            return $this->fetch();
        }

        $id = input('post.id',0);
        $access_ids = input('post.access_ids/a',[]);

        if( !$id ){
            return ['msg' => '您指定的角色不存在', 'code' => -1];
        }

        $info = \app\index\model\Role::where('id',$id)->find();
        if( !$info ){
            return ['msg' => '您指定的角色不存在', 'code' => -1];

        }


        //获取已分配的权限
        $assign_access_ids = RoleAccess::where('role_id',$id)->column('access_id');

        /**
         * 找出删除的权限
         * 假如已有的权限集合是A，界面传递过得权限集合是B
         * 权限集合A当中的某个权限不在权限集合B当中，就应该删除
         * 使用 array_diff() 计算补集
         */
        $delete_access_ids = array_diff( $assign_access_ids,$access_ids );
        if( $delete_access_ids ){
            foreach( $delete_access_ids as $_access_id ) {
                RoleAccess::where('role_id',$id)->where('access_id',$_access_id)->delete();
            }

        }


        /**
         * 找出添加的权限
         * 假如已有的权限集合是A，界面传递过得权限集合是B
         * 权限集合B当中的某个权限不在权限集合A当中，就应该添加
         * 使用 array_diff() 计算补集
         */
        $new_access_ids = array_diff( $access_ids,$assign_access_ids );
        if( $new_access_ids ){
            foreach( $new_access_ids as $_access_id  ){
                RoleAccess::create([
                    'role_id' => $id,
                    'access_id' => $_access_id
                ]);
            }
        }

        return ['msg' => '操作成功', 'code' => 200];


    }
}
