<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Pic helper
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class PicHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Other helpers used by FormHelper
     *
     * @var array
     */
    public $helpers = ['Url'];

    /*
     * 图片路径处理 判断远程图片和本地图片
     * @param $image 图片地址
     * @param $default 默认返回图片地址：holder.js/150x150?text=图片&theme=sky&size=11
     * @param $bool 返回布尔值
     *
     * */
    public function url($image, $default = 'holder.js/150x150?text=图片&theme=sky&size=11', $bool = false)
    {
        if (empty($image)) {
            return ($bool) ? false : $default;
        }

        //判断是否为远程图片
        if (!preg_match("~^(?:f|ht)tps?://~i", $image))
        {
            return $this->Url->webroot($image);
        } else {
            //验证远程图片是否存在
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $image);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);

            $contents = curl_exec($ch);
            if (preg_match("/404/", $contents)){
                return ($bool) ? false : $default;
            }
        }
        return $image;
    }



}
