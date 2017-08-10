<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
class CommonController extends Controller {

    public $loginMarked;
    /**
      +----------------------------------------------------------
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
      +----------------------------------------------------------
     */
    public function _initialize() {
        // header("Content-Type:text/html; charset=utf-8");
        $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
        if (empty($systemConfig['TOKEN']['admin_marked'])) {
            $systemConfig['TOKEN']['admin_marked'] = "admin.oncoo.net";
            $systemConfig['TOKEN']['admin_timeout'] = 3600;
            $systemConfig['TOKEN']['member_marked'] = "home.oncoo.net";
            $systemConfig['TOKEN']['member_timeout'] = 3600;
            set_config("systemConfig", $systemConfig, APP_PATH . "Common/Conf/");
            if (is_dir(WEB_ROOT . "install/")) {
                //delDirAndFile(WEB_ROOT . "install/", TRUE);
            }
        }
        $this->lock_id = C('LOCK_ID'); //系统默认所需id数组，防止用户删除或编辑
        $this->loginMarked = md5($systemConfig['TOKEN']['admin_marked']);
        $this->aid =$_SESSION['my_info']['aid'];
        $this->checkLogin();
        // 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(CONTROLLER_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
           // import('ORG.Util.RBAC');
            if (!RBAC::AccessDecision()) {
                //检查认证识别号
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(C('USER_AUTH_GATEWAY'));
//                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
//                     echo L('_VALID_ACCESS_');
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
        $this->upWholeUrl = '//static.fjsxpmh.com'.trim(C('UPLOADS_PICPATH'),'.');
        $this->assign("menu", $this->show_menu());
        $this->assign("sub_menu", $this->show_sub_menu());
        $this->assign("my_info", $_SESSION['my_info']);
        $this->assign("site", $systemConfig);
        $this->assign("business_name", $_SESSION['business_name']);
        

      //  $this->getQRCode();
    }

    protected function getQRCode($url = NULL) {
        if (IS_POST) {
            $this->assign("QRcodeUrl", "");
        } else {
//            $url = empty($url) ? C('WEB_ROOT') . $_SERVER['REQUEST_URI'] : $url;
            $url = empty($url) ? C('WEB_ROOT') . U(CONTROLLER_NAME . '/' . ACTION_NAME) : $url;
            /*import('QRCode');
            $QRCode = new QRCode('', 80);
            $QRCodeUrl = $QRCode->getUrl($url);
            $this->assign("QRcodeUrl", $QRCodeUrl);*/
        }
    }

    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
                setcookie($this->loginMarked, NULL, -$timeout['admin_timeout'], "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                $this->error("登录超时，请重新登录", U("Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie($this->loginMarked, $cookie[0] . "_" . time(), 0, "/");
                } else {
                    setcookie($this->loginMarked, NULL, -$timeout['admin_timeout'], "/");
                    unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    $this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
            $this->redirect("Public/index");
        }
        return TRUE;
    }

    /**
      +----------------------------------------------------------
     * 验证token信息
      +----------------------------------------------------------
     */
    protected function checkToken() {
        if (IS_POST) {
            if (!M("Admin")->autoCheckToken($_POST)) {
                die(echojson(array('status' => 0,'msg'=>'重复提交数据，请刷新页面重试！', 'info' => '重复提交数据，请刷新页面重试！','url'=>__SELF__)));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

    /**
      +----------------------------------------------------------
     * 显示一级菜单
      +----------------------------------------------------------
     */
    private function show_menu() {
        $cache = C('admin_big_menu');
        $count = count($cache);
        $i = 1;
        $menu = "";
        foreach ($cache as $url => $name) {
            if ($i == 1) {
                $css = $url == CONTROLLER_NAME || !$cache[CONTROLLER_NAME] ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else if ($i == $count) {
                $css = $url == CONTROLLER_NAME ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else {
                $css = $url == CONTROLLER_NAME ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            }
            $i++;
        }
        return $menu;
    }

    /**
      +----------------------------------------------------------
     * 显示二级菜单
      +----------------------------------------------------------
     */
    private function show_sub_menu() {
        $big = CONTROLLER_NAME == "Index" ? "Common" : CONTROLLER_NAME;
        $cache = C('admin_sub_menu');
        $sub_menu = array();
        if ($cache[$big]) {
            $cache = $cache[$big];
            foreach ($cache as $url => $title) {
                $url = $big == "Common" ? $url : "$big/$url";
                $sub_menu[] = array('url' => U("$url"), 'title' => $title);
            }
            return $sub_menu;
        } else {
            return $sub_menu[] = array('url' => '#', 'title' => "该菜单组不存在");
        }
    }

}