<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Roles Controller
 *
 * @property \Admin\Model\Table\RolesTable $Roles
 *
 * @method \Admin\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{

    public $paginate = [
        'order' => [
            'Roles.id' => 'desc'
        ]
    ];


    public function index()
    {
        $this->setPage();
        $data = $this->paginate($this->Roles);

        $this->set(compact('data'));
    }



    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                return $this->jump(200, '保存成功!');
            } else {
                return $this->getError($role);
            }
        }
    }


    public function edit($id = null)
    {
        $data = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Roles->patchEntity($data, $this->request->getData());
            if ($this->Roles->save($data)) {
                return $this->jump(200, '编辑成功!');
            } else {
                return $this->getError($data);
            }
        }
        $this->set(compact('data'));
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $have = TableRegistry::getTableLocator()->get('Admin.Users')->find()
            ->where(['role_id' => $id])->first();

        if (!empty($have)) {
            return $this->jump(300, '删除失败,请先删除该用户组下所有用户!', 'roles', false);
        }

        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            return $this->jump(200, '删除成功!', '', false);
        } else {
            return $this->jump(300, '删除失败,请重试!', '', false);
        }
    }

    /*
     * 管理员组的权限管理
     *
     * */
    public function manage($id = null) {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(array('post', 'put'))) {
            $menus = explode(',', $this->request->getData('menus'));
            $saveData = $this->request->getData();
            $saveData['menus'] = json_encode($menus);
            $role = $this->Roles->patchEntity($role, $saveData);
            if ($this->Roles->save($role)) {
                return $this->jump(200, '保存成功!', false, true);
            } else {
                return $this->getError($role);
            }
        }
        $menu = TableRegistry::getTableLocator()->get('Admin.Menus')->findMenu();          //获取所有菜单
        $roleData = $this->Roles->getData(array('Roles.id' => $id));
        $haveMenus = (empty($roleData->menus)) ? array() : json_decode($roleData->menus);
        $haveMenuStr = implode(',', $haveMenus);

        $this->set(compact('menu', 'id', 'haveMenus', 'haveMenuStr'));
    }


    /*
    * 管理员组的权限管理
    *
    * */
    public function rules($id = null) {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(array('post', 'put'))) {
            $rules = explode(',', $this->request->getData('rules'));
            $saveData = $this->request->getData();
            $saveData['rules'] = json_encode($rules);
            $role = $this->Roles->patchEntity($role, $saveData);
            if ($this->Roles->save($role)) {
                return $this->jump(200, '保存成功!', 'roles', true);
            } else {
                return $this->getError($role);
            }
        }
        $rules = TableRegistry::getTableLocator()->get('Admin.AuthRules')->find()
            ->all();          //获取所有菜单

        $haveRules = (empty($role->rules)) ? array() : json_decode($role->rules);
        $haveRuleStr = implode(',', $haveRules);

        $this->set(compact('rules', 'id', 'haveRules', 'haveRuleStr'));
    }
}
