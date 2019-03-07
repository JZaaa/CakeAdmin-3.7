<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \Admin\Model\Table\UsersTable $Users
 *
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'relogin']);
    }

    /**
     * 登录
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if (!empty($this->request->getData())) {
                $tip = '用户名或密码错误';
                $user = $this->Auth->identify();
                if ($user && $user['state'] == 1) {
                    $rules = $this->Users->Roles->find()
                        ->select([
                            'Roles.id', 'Roles.menus'
                        ])
                        ->where([
                            'Roles.id' => $user['role_id']
                        ])->first();
                    $user['rules'] = (empty($rules['menus'])) ? [] : json_decode($rules['menus']);
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                if ($user && $user['state'] == 2) {
                    $tip = '您已被禁止登录，如有疑问，请联系管理员！';
                }
                $this->Flash->error($tip, ['key' => 'tip']);
            }
        }
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $systemData = TableRegistry::getTableLocator()->get('Admin.Options')
            ->getArrayData([
                'Options.type' => 'system'
            ]);

        $this->set(compact('systemData'));

    }


    /**
     * 登出
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->setPage();
        $this->paginate['contain'] = 'Roles';

        //用户名查询
        $conditions = array();
        if (!empty($this->request->getData('username'))) {
            $username = $this->request->getData('username');
            $conditions['Users.username like'] = '%' . $username . '%';
            $this->set('username', $username);
        }

        //管理用户组查询
        if (!empty($this->request->getData('role_id'))) {
            $role_id = $this->request->getData('role_id');
            $conditions['Users.role_id'] = $role_id;
            $this->set('role_id', $role_id);
        }

        $query = $this->Users->find()->where($conditions);
        $data = $this->paginate($query);

        $sexData = $this->Users->sexData();         //性别
        $stateData = $this->Users->stateData();     //状态
        $colorData = $this->Users->colorData();     //颜色
        $roleData = TableRegistry::getTableLocator()->get('Admin.Roles')->getAllRole()->all();    //获取所有管理员组


        $this->set(compact('data', 'sexData', 'stateData', 'colorData', 'roleData'));
    }

    /**
     * 添加用户
     * @return \App\Controller\AppController
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                return $this->jump(200, '添加成功!');
            } else {
                return $this->getError($user);
            }
        }

        $roleData = TableRegistry::getTableLocator()->get('Admin.Roles')->getAllRole();    //获取所有管理员组
        $this->set(compact('roleData'));
    }

    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($data['username'] == 'admin' && $this->Auth->user('username') != 'admin') {
            return $this->jump(300, '当前账号无权限更改此用户!');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $saveData = $this->request->getData();
            if (empty($saveData['password'])) {
                unset($saveData['password']);
            }
            $data = $this->Users->patchEntity($data, $saveData);
            if ($this->Users->save($data)) {
                return $this->jump(200, '编辑成功!');
            } else {
                return $this->getError($data);
            }
        }

        $stateData = $this->Users->stateData();     //状态
        $roleData = TableRegistry::getTableLocator()->get('Admin.Roles')->getAllRole();    //获取所有管理员组
        $this->set(compact('data', 'roleData', 'stateData'));
    }

    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($user['username'] == 'admin') {
            return $this->jump(300, '该用户禁止删除!');
        }
        if ($this->Users->delete($user)) {
            return $this->jump(200, '删除成功!', '', false);
        } else {
            return $this->jump(300, '删除失败,请重试!');
        }
    }


    /**
     * 重登录
     * @return \App\Controller\AppController
     */
    public function relogin() {
        if (!empty($this->request->getData())) {
            $user = $this->Auth->identify();
            if ($user && $user['state'] == 1) {
                $rules = $this->Users->Roles->find()
                    ->select([
                        'Roles.id', 'Roles.menus'
                    ])
                    ->where([
                        'Roles.id' => $user['role_id']
                    ])->first();
                $user['rules'] = (empty($rules['menus'])) ? [] : json_decode($rules['menus']);
                $this->Auth->setUser($user);
                return $this->jump(200, '登录成功!');
            } else {
                return $this->jump(300, '登录失败!');
            }
        }
    }

    /*
     * 我的资料
     *
     * */
    public function myinfo()
    {
        $id = $this->Auth->user('id');
        $data = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Users->patchEntity($data, $this->request->getData());
            if ($this->Users->save($data)) {
                return $this->jump(200, '编辑成功!');
            } else {
                return $this->getError($data);
            }
        }
        $this->set(compact('data'));
    }

    /*
     * 修改密码
     *
     * */
    public function resetpasswd()
    {
        $id = $this->Auth->user('id');
        $data = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Auth->identify();
            if (!$user) {
                return $this->jump(300, '修改密码失败,原密码错误!');
            }
            $saveData = $this->request->getData();
            $saveData['password'] = $saveData['new'];
            $data = $this->Users->patchEntity($data, $saveData);
            if ($this->Users->save($data)) {
                return $this->jump(200, '修改密码成功!');
            } else {
                return $this->getError($data);
            }
        }
        $this->set(compact('data'));
    }

}
