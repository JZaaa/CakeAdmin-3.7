<?php
/**
 * Created by PhpStorm.
 * User: jzaaa
 * Date: 2019/2/28
 * Time: 16:27
 */

namespace App\View\Helper;
use Cake\View\Helper;


class ToolHelper extends Helper
{
    protected $colorArray = [
        1 => 'success',
        2 => 'default',
        3 => 'danger'
    ];

    /**
     * 返回bool标签样式
     * @param $value
     * @param array $dataArray
     * @return string
     */
    public function boolLabel($value, $dataArray = [])
    {
        if (empty($dataArray)) {
            $dataArray = [
                1 => '是',
                2 => '否'
            ];
        }
        $text = isset($dataArray[$value]) ? $dataArray[$value] : '未知';
        $color = isset($this->colorArray[$value]) ? $this->colorArray[$value] : 'default';
        return '<span class="label label-'. $color .'">' . $text . '</span>';

    }

    // 字母select
    public function letterSelect($class)
    {
        $select = '<select class="'. $class .'" data-toggle="selectpicker" data-live-search="true" data-width="50px">';

        foreach (range('A', 'Z') as $char) {
            $select .= '<option value="' . $char . '">' . $char . '</option>';
        }

        $select .= '</select>';

        return $select;
    }

}