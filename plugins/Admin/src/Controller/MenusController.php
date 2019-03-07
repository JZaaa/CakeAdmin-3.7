<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \Admin\Model\Table\MenusTable $Menus
 *
 * @method \Admin\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $data = $this->Menus->findAllMenu();
        $stateData = $this->Menus->stateData();     //状态
        $colorData = $this->Menus->colorData();     //状态

        $this->set(compact('data', 'stateData', 'colorData'));
    }

    /*
     * 菜单查找带回
     *
     * */
    public function lookup($id = null)
    {
        $data = $this->Menus->findAllMenu($id);
        $this->set(compact('data'));
    }

    /**
     * 添加
     * @param null $parent_id
     * @return \App\Controller\AppController
     */
    public function add($parent_id = null)
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $saveData = $this->Menus->changeData($this->request->getData());
            if ($saveData['parent_id'] == 0) {
                $saveData['parent_id'] = null;
            }
            $menu = $this->Menus->patchEntity($menu, $saveData);
            if ($this->Menus->save($menu)) {
                return $this->jump(200);
            } else {
                return $this->getError($menu);
            }
        }
        if (!empty($parent_id)) {
            $data = $this->Menus->get($parent_id, [
                'contain' => ['ParentMenus']
            ]);
            $this->set(compact('data'));
        }
    }

    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->Menus->get($id, [
            'contain' => ['ParentMenus']
        ]);

        if ($data->is_system == 1) {
            return $this->jump(300, '此菜单不允许修改！');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $saveData = $this->Menus->changeData($this->request->getData());
            $saveData = $this->Menus->patchEntity($data, $saveData);
            if ($this->Menus->save($saveData)) {
                return $this->jump(200, '编辑成功!');
            } else {
                return $this->getError($saveData);
            }
        }
        $stateData = $this->Menus->stateData();     //状态
        $this->set(compact('data', 'stateData'));
    }


    /**
     * 删除菜单
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        //判断是否存在子菜单
        $conditions['Menus.parent_id'] = $id;
        if ($this->Menus->haveChild($conditions)) {
            return $this->jump(300, '删除失败,请先删除所有子菜单!');
        }

        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);

        if ($this->Menus->delete($menu)) {
            return $this->jump(200, '删除成功!', '', false);
        } else {
            return $this->getError($menu);
        }
    }
}
