<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \Admin\Model\Table\AdUsersTable|\Cake\ORM\Association\HasMany $AdUsers
 *
 * @method \Admin\Model\Entity\Role get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Role|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Role|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolesTable extends Table
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

        $this->setTable('ad_roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Users', [
            'foreignKey' => 'role_id',
            'className' => 'Admin.AdUsers'
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
            ->maxLength('name', 50, '名称超出长度')
            ->allowEmptyString('name');

        $validator
            ->scalar('menus')
            ->allowEmptyString('menus');

        $validator
            ->scalar('note')
            ->maxLength('note', 100, '备注超出长度')
            ->allowEmptyString('note');

        $validator
            ->integer('sort')
            ->allowEmptyString('sort');

        return $validator;
    }

    /*
  * 获取所有管理员组
  *
  * */
    public function getAllRole()
    {
        return $query = $this->find('all', [
            'order' => ['Roles.id' => 'desc']
        ]);
    }

    /*
     * 获取数据详情
     *
     * */
    public function getData($conditions = array()) {
        $query = $this->find('all')
            ->where($conditions);
        return $query->first();
    }
}
