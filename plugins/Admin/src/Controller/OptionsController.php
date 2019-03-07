<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

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
        $conditions = [];
        if (!empty($type)) {
            $conditions['Options.type'] = $type;
        }

        $data = $this->Options->find()
            ->where($conditions)
            ->all();

        if ($this->request->is('post')) {
            $newData = $this->request->getData();
            $data = $data->indexBy('field')
                ->toArray();

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
                return $this->jump(200, '保存成功!', false, false);
            } else {
                return $this->getError($entity);
            }
        }

        $data = $data->combine('field', 'value')->toArray();

        $this->set(compact('type', 'data'));
    }


}
