<?php

namespace App\Http\Util;
/**
 * 图片工具类
 * Created by PhpStorm.
 * Author: jwu049
 * Since: 2017/7/13 11:52
 */
class ImageUtil
{
    //允许上传的图片类型
    private static $__allowed_image_types = ['jpeg', 'jpg', 'gif', 'gpeg', 'png'];

    /**
     * 获取允许上传的图片类型
     * @return array
     */
    public static function getAllowedImageTypes()
    {
        return self::$__allowed_image_types;
    }

    public static function getImageName($image_path)
    {
        if(empty($image_path)) {
            return '';
        }
        $image_info = explode('/', $image_path);
        return end($image_info);
    }

    public static function getImageExtension($image_name)
    {
        if(empty($image_name)) {
            return '';
        }
        $extension_info = explode('.', $image_name);
        return end($extension_info);
    }

}