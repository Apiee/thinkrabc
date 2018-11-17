<?php
/**
 * Created by PhpStorm.
 * User: 白菜
 * Date: 2018/10/16
 * Time: 16:06
 */

namespace app\index\controller;


use app\index\model\RoleAccess;
use app\index\model\UserRole;
use think\Controller;

class Common extends Controller
{
    protected $authCookieName = "baicai88";
    protected $currentUser = null;

    public $privilege_urls = [];//保存去的权限链接

    protected $beforeActionList = [
        'beforeLogin' => ['except' => 'vlogin,login'],
    ];
//    protected $allowAllAction = [
//        'user/login'
//    ];

    public function beforeLogin()
    {
        $loginStatus = $this->checkLoginStatus();
        if (!$loginStatus) {
            if (request()->isAjax()) {
                $this->error('未登录,请返回用户中心');
            } else {
                $this->redirect("index/user/login");//返回到登录页面
            }
            return false;
        }


        $res = $this->checkPrivilege(request()->path());
        if (!$res) {
            $this->error('无权限访问');
        }

    }


    public function checkPrivilege( $url ){
        //如果是超级管理员 也不需要权限判断
        if( $this->currentUser && $this->currentUser['is_admin'] ){
            return true;
        }

//        //有一些页面是不需要进行权限判断的,这个不需要了,tp自带前置操作
//        if( in_array( $url,$this->ignore_url ) ){
//            return true;
//        }

        return in_array( $url, $this->getRolePrivilege() );
    }



    //验证登录是否有效，返回 true or  false
    protected function checkLoginStatus()
    {
        $authCookie = cookie($this->authCookieName);
        if (!$authCookie) {
            return false;
        }
        list($authCookie, $uid) = explode("#", $authCookie);

        if (!$authCookie || !$uid) {
            return false;
        }

        if ($uid && preg_match("/^\d+$/", $uid)) {
            $userInfo = \app\index\model\User::get($uid);
            if (!$userInfo) {
                return false;
            }
            //校验码
            if ($authCookie != $this->createAuthToken($userInfo['id'], $userInfo['name'], $userInfo['email'], $_SERVER['HTTP_USER_AGENT'])) {
                return false;
            }
            $this->currentUser = $userInfo;
            $this->assign('currentuser', $userInfo);
            return true;
        }
        return false;
    }


    //设置登录态cookie
    public function createLoginStatus($userInfo)
    {
        $userAuthToken = $this->createAuthToken($userInfo['id'], $userInfo['name'], $userInfo['email'], $_SERVER['HTTP_USER_AGENT']);
        cookie($this->authCookieName, $userAuthToken . "#" . $userInfo['id']);
    }

    //用户相关信息生成加密校验码函数
    public function createAuthToken($uid, $name, $email, $user_agent)
    {
        return md5($uid . $name . $email . $user_agent);
    }


    /**
     * 判断权限的逻辑是
     * 取出当前登录用户的所属角色，
     * 在通过角色 取出 所属 权限关系
     * 在权限表中取出所有的权限链接
     *
     * 判断当前访问的链接 是否在 所拥有的权限列表中
     */


    public function getRolePrivilege($uid = 0)
    {
        if (!$uid && $this->currentUser) {
            $uid = $this->currentUser->id;
        }
        if (!$this->privilege_urls) {
            $role_ids = UserRole::where('uid', $uid)->column('role_id');
            if ($role_ids) {
                //在通过角色 取出 所属 权限关系
                $access_ids = RoleAccess::where('role_id', 'in', $role_ids)->column('access_id');
                //在权限表中取出所有的权限链接
                $list = \app\index\model\Access::where('id', 'in', $access_ids)->select();
                if ($list) {
                    foreach ($list as $_item) {
                        $tmp_urls = json_decode($_item['urls'], true);
                        $this->privilege_urls = array_merge($this->privilege_urls, $tmp_urls);
                    }
                }
            }
        }
        return $this->privilege_urls;
    }


}