<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Admin\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \Admin\Model\Entity\User get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('ad_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'Admin.Roles'
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
            ->scalar('username')
            ->maxLength('username', 50, '用户名超出长度')
            ->allowEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 100, '密码超出长度')
            ->allowEmptyString('password');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 50, '昵称超出长度')
            ->allowEmptyString('nickname');

        $validator
            ->allowEmptyString('state');

        $validator
            ->allowEmptyString('sex');

        $validator
            ->scalar('telphone')
            ->maxLength('telphone', 20, '电话超出长度')
            ->allowEmptyString('telphone');

        $validator
            ->email('email', '不合法的email地址')
            ->allowEmptyString('email');

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
        $rules->add($rules->isUnique(['username'], '用户名已存在'));
        $rules->add($rules->existsIn(['role_id'], 'Roles', '无匹配用户组'));

        return $rules;
    }

    /*
   * 用户性别
   *
   * */
    public function sexData()
    {
        return $data = array(
            '1' => '男',
            '2' => '女',
            '3' => '保密'
        );
    }

    /*
     * 用户状态
     *
     * */
    public function stateData()
    {
        return $data = array(
            '1' => '正常',
            '2' => '禁止'
        );
    }

    /*
     * 用户颜色
     *
     * */
    public function colorData()
    {
        return $data = array(
            '1' => 'success',
            '2' => 'default'
        );
    }

    /*
     * 检查用户是否已存在
     *
     * */
    public function isHave($conditions = array())
    {
        $query = $this->find()
            ->where($conditions)->first();
        return !empty($query);
    }
}
