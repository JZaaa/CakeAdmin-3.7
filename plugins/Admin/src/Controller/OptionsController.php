<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Cache\Cache;

/**
 * Options Controller
 *
 * @property \Admin\Model\Table\OptionsTable $Options
 *
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionsController extends AppController
{

    public function index($type = null)
    {
        $data = $this->Options->getArrayData();
        if ($this->request->is('post')) {
            if ($this->Options->saveData($type, $this->request->getData())) {
                return $this->jump(200, '保存成功!', '', false, '');
            }
        }
        $this->set(compact('type', 'data'));
    }


    /**
     * 抽奖配置
     * @return \App\Controller\AppController
     * @throws \Exception
     */
    public function cog()
    {
        $data = $this->Options->find()
            ->where([
                'type' => 'activity'
            ])
            ->all()
            ->indexBy('field')
            ->toArray();


        if ($this->request->is('post')) {
            $newData = $this->request->getData();

            $saveData = [];
            foreach ($newData as $key => $item) {
                // 存在
                if (isset($data[$key])) {
                    $saveData[] = [
                        'id' => $data[$key]['id'],
                        'value' => $item,
                    ];
                } else {
                    $saveData[] = [
                        'field' => $key,
                        'value' => $item,
                        'type' => 'activity'
                    ];
                }
            }

            $entity = $this->Options->patchEntities($data, $saveData);

            if ($this->Options->saveMany($entity)) {
                Cache::delete('site', 'site');
                return $this->jump(200, '保存成功!', 'false', false, '');
            } else {
                return $this->getError($entity);
            }
        }


        $this->set(compact('data'));

    }
}
