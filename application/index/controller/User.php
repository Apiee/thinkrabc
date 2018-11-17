<?php

namespace app\index\controller;

use app\index\model\UserRole;

class User extends Common
{
    public function index()
    {
        $roleRes = \app\index\model\User::order('id', 'desc')->paginate(2);
        $this->assign('roleres', $roleRes);
        return $this->fetch();
    }

    public function set()
    {
        if (request()->isGet()) {
            $id = input('param.id', 0);
            $info = [];
            if ($id) {
                $info = \app\index\model\User::where('id', $id)->find();
            }

            //取出所有的角色
            $roleList =  \app\index\model\Role::order('id','desc')->select();

            //取出所有的已分配角色
            $user_role_list = UserRole::where('uid',$id)->field('role_id')->column('role_id');
//            $related_role_ids = array_column($user_role_list,"role_id"); //不生效,$user_role_list不是纯数组

            $this->assign('related_role_ids',$user_role_list);
            $this->assign('role_list',$roleList);
            $this->assign('info', $info);
            return $this->fetch();
        }

        $name = input('post.name', '');
        $email = input('post.email', '');
        $id = input('post.id', 0);
        $roleIds = input('post.role_ids/a',[]);
        if (mb_strlen($name, 'utf-8') < 1 || mb_strlen($name, 'utf-8') > 20) {
            return json(['msg' => '请输入合法的名称', 'code' => -1]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json(['msg' => '请输入合法的邮箱', 'code' => -1]);
        }

        $userInfo = \app\index\model\User::where('email', $email)->where('id', '<>', $id)->find();

        if ($userInfo) {
            return ['msg' => '该角色已经存在', 'code' => -1];
        }

        $info = \app\index\model\User::where('id', $id)->find();

        if ($info) {
            //编辑
            $res = \app\index\model\User::update([
                'id' => $id,
                'name' => $name,
                'email' => $email
            ]);
        } else {
            //添加
            $res = \app\index\model\User::create([
                'name' => $name,
                'email' => $email
            ]);
        }

        /**
         * 找出删除的角色
         * 假如已有的角色集合是A，界面传递过得角色集合是B
         * 角色集合A当中的某个角色不在角色集合B当中，就应该删除
         * array_diff();计算补集
         */
        $user_role_list = UserRole::where('uid',$id)->select();
        $related_role_ids = [];
        if( $user_role_list ){
            foreach( $user_role_list as $_item ){
                $related_role_ids[] = $_item['role_id'];
                if( !in_array( $_item['role_id'],$roleIds ) ){
                    $_item->where('role_id',$_item['role_id'])->where('uid',$id)->delete();
//                    UserRole::where('role_id',$_item['role_id'])->delete();
                }
            }
        }

        /**
         * 找出添加的角色
         * 假如已有的角色集合是A，界面传递过得角色集合是B
         * 角色集合B当中的某个角色不在角色集合A当中，就应该添加
         */

        if ( $roleIds ){
            foreach( $roleIds as $_role_id ){
                if( !in_array( $_role_id ,$related_role_ids ) ){
//                    添加
                    UserRole::create([
                        'uid' => $res->id,
                        'role_id' => $_role_id
                    ]);
                }
            }
        }


        return ['msg' => '操作成功', 'code' => 200];
    }


    public function login()
    {
        return $this->fetch();
    }

    //伪登录方法
    public function vLogin()
    {
        $uid = request()->get('uid', 0);
        if (!$uid) {
            return $this->redirect('/');
        }
        $userInfo = \app\index\model\User::get($uid);
//        halt($userInfo);
        if (!$userInfo) {
            return $this->redirect('/');
        }
        //cookie保存登录态,cookie值加密 约定一个规则 userAuthToken + "#" + uid
        $this->createLoginStatus($userInfo);

        return $this->redirect('index/index');

    }
}
