<?php
/**
 * Created by PhpStorm.
 * User: jzaaa
 * Date: 2019/2/19
 * Time: 11:16
 */

namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;


class HomeController extends AppController
{

    /**
     * 框架入口
     */
    public function index()
    {
        $userData = $this->Auth->user();
        $menuData = TableRegistry::getTableLocator()->get('Admin.Menus')->getMenus($userData['role_id'], $userData['rules']);
        $systemData = TableRegistry::getTableLocator()->get('Admin.Options')->getArrayData(array('Options.type' => 'system'));

        $this->set(compact('userData', 'menuData', 'systemData'));
    }

    /**
     * 我的主页
     */
    public function main()
    {

    }

}