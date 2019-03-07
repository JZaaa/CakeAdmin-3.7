<?php
namespace Admin\Model\Table;

use Cake\Collection\Collection;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Admin\Model\Table\MenusTable|\Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \Admin\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $ChildMenus
 *
 * @method \Admin\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Menu newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Menu|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MenusTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ad_menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentMenus', [
            'className' => 'Admin.Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Admin.Menus',
            'foreignKey' => 'parent_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50, '菜单名称超出长度')
            ->allowEmptyString('name');

        $validator
            ->allowEmptyString('level');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 20, '图标超出长度')
            ->allowEmptyString('icon');

        $validator
            ->scalar('target')
            ->maxLength('target', 50, '链接超出长度')
            ->allowEmptyString('target');

        $validator
            ->scalar('reload')
            ->maxLength('reload', 20, '标识超出长度')
            ->allowEmptyString('reload');

        $validator
            ->allowEmptyString('sort');

        $validator
            ->allowEmptyString('isshow');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus', '无匹配父菜单'));

        return $rules;
    }


    /*
   * 状态
   *
   * */
    public function stateData()
    {
        return $data = array(
            '1' => '显示',
            '2' => '隐藏'
        );
    }

    /*
     * 颜色
     *
     * */
    public function colorData()
    {
        return $data = array(
            '1' => 'success',
            '2' => 'default'
        );
    }


    /**
     * 查询所有菜单
     * @param null $not_id
     * @return array|Collection|\Cake\Collection\CollectionInterface|\Cake\Collection\CollectionTrait
     */
    public function findAllMenu($not_id = null)
    {
        $tree = $this->find()
            ->select([
                'icon', 'level', 'parent_id', 'name', 'id', 'isshow', 'reload', 'target', 'sort'
            ])
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ])
            ->nest('id', 'parent_id');


        if (!empty($not_id)) {
            $tree = $tree->toList();

            $tree = $this->filterTree($tree, $not_id);

            $tree = new Collection($tree);
        }

        $tree = $tree->listNested()->toList();


        return $tree;

    }


    /**
     * 菜单树过滤
     * @param array $tree 菜单树
     * @param null $not_id 过滤菜单id及其子菜单
     * @return array
     */
    private function filterTree(array $tree, $not_id = null)
    {

        foreach ($tree as $key => $item) {
            if ($item->id == $not_id) {
                unset($tree[$key]);
                continue;
            }

            if (!empty($item->children)) {
                $item->children = $this->filterTree($item->children, $not_id);
            }
        }

        return $tree;

    }

    /*
     * 查找菜单
     *
     * */
    public function findMenu($conditions = null) {
        $query = $this->find()
            ->where($conditions)
            ->order(['level' => 'asc', 'sort' => 'desc', 'created' => 'asc'])
            ->toArray();
        return $query;
    }

    /*
     * 数据转换
     *
     * */
    public function changeData($data = array())
    {
        $data['sort'] = !empty($data['sort']) ? $data['sort'] : 0;
        $data['parent_id'] = (!empty($data['parent_id']) || $data['parent_id'] == 0)  ? $data['parent_id'] : null;
        $data['level'] = empty($data['parent_level']) ? 1 : $data['parent_level'] + 1;
//        if (empty($data['icon'])) {
//            $data['icon'] = 'caret-right';
//        }
        return $data;
    }

    /*
     * 判断是否存在子菜单
     *
     * */
    public function haveChild($conditions = array()) {
        $query = $this->find('all', [
            'conditions' => $conditions
        ]);
        $total = $query->count();
        $result = ($total>0) ? true : false;
        return $result;
    }


    /**
     * 获取菜单树，两个参数必须设置一个
     * 当$role_id不为空，且$menus_id为空时，将会从数据库查询role_id对应菜单id
     * @param null $role_id 用户组id
     * @param array $menus_ids 查询菜单ids 数组
     * @return array
     */
    public function getMenus($role_id = null, $menus_ids = null)
    {
        $menus = [];

        // 动态获取
        if (!empty($role_id)) {
            $roleMenu = TableRegistry::getTableLocator()->get('Admin.Roles')->getData(array('Roles.id' => $role_id));
            $menus_ids = json_decode($roleMenu->menus);
        }

//        if (is_null($menus_ids) && !empty($role_id)) {
//            $roleMenu = TableRegistry::getTableLocator()->get('Admin.Roles')->getData(array('Roles.id' => $role_id));
//            $menus_ids = json_decode($roleMenu->menus);
//        }

        if (!empty($menus_ids)) {
            // 生成菜单树
            $menus = $this->find()
                ->select([
                    'icon', 'level', 'parent_id', 'name', 'id', 'isshow', 'reload', 'target'
                ])
                ->where([
                    'id in' => $menus_ids
                ])
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ])
                ->reject(function ($item) {
                    // 删除隐藏菜单
                    return $item->isshow != 1;
                })
                ->nest('id', 'parent_id') // 生成树
                ->filter(function ($item) {
                    // 返回包含根菜单的新数组
                    return $item->parent_id == 0;
                })
                ->toArray();

        }
        return $menus;

    }

}
