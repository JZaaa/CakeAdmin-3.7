<?php

namespace Admin\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{

    public function initialize()
    {
        parent::initialize();
        try {
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'userModel' => 'Admin.Users'
                    ]
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'login',
                    'plugin' => 'Admin'
                ],
                'loginRedirect' => [
                    'controller' => 'Home',
                    'action' => 'index',
                    'plugin' => 'Admin'
                ],
                'storage' => [
                    'className' => 'Session',
                    'key' => 'Admin.User'
                ]
            ]);
        } catch (\Exception $e) {
            echo '网站异常！';
            exit;
        }

        $this->limit = 20;  //每页显示条数

        $this->viewBuilder()->setLayout('ajax');

    }

    /**
     * 页面跳转函数
     * 调用必须 return
     * @param int statusCode 必选。状态码(ok = 200, error = 300, timeout = 301)
     * @param string message 可选。信息内容。
     * @param string tabid 可选。待刷新navtab id，多个id以英文逗号分隔开，当前的navtab id不需要填写
     * @param string dialogid 可选。待刷新dialog id，多个id以英文逗号分隔开，请不要填写当前的dialog id。
     * @param string divid 可选。待刷新div id，多个id以英文逗号分隔开
     * @param boolean closeCurrent 可选。是否关闭当前窗口(navtab或dialog)。
     * @param string forward 可选。跳转到某个url。
     * @param string forwardConfirm 可选。跳转url前的确认提示信息。
     * @return BaseController
     */
    public function jump($statusCode, $message = null, $tabid = '', $closeCurrent = true, $forward = '', $divid = '', $dialogid = '', $forwardConfirm = '')
    {
        $result = array();
        if (empty($message)) {
            switch ($statusCode) {
                case 200:
                    $message = '操作成功';
                    break;
                case 300:
                    $message = '操作失败';
                    break;
                case 403:
                    $message = '无权限访问';
                    break;
                default:
                    $message = '未知错误';
            }
        }
        $result['statusCode'] = empty($statusCode) ? 200 : $statusCode;
        $result['message'] = $message;
        $result['tabid'] = strtolower($tabid);
        $result['forward'] = $forward;
        $result['dialogid'] = $dialogid;
        $result['divid'] = $divid;
        $result['forwardConfirm'] = $forwardConfirm;
        $result['closeCurrent'] = $closeCurrent;
        return parent::apiResponse($result);
    }


    /**
     * 返回错误提示
     * 调用必须return
     * @param $entity object 数据实体
     * @param $jump bool 是否自动跳转, 否则返回错误信息
     * @return BaseController
     */
    public function getError($entity, $jump = true)
    {
        try{
            $message = current(current($entity->getErrors()));
        } catch (\Exception $e) {
            $message = null;
        }

        return $jump ? $this->jump(300, '操作失败！' . $message, false) : $message;
    }

    /*
     * 分页参数设置
     *
     * */
    public function setPage()
    {
        $page = !empty($this->request->getData('pageCurrent')) ? $this->request->getData('pageCurrent') : 1;
        $numPerPage = !empty($this->request->getData('pageSize')) ? $this->request->getData('pageSize') : $this->limit;
        $this->paginate['page'] = $page;
        $this->paginate['limit'] = $numPerPage;

        $this->set(compact('page', 'numPerPage'));
    }

}
