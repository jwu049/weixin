<?php
namespace App\Http\Util;

/**
 * Created by PhpStorm.
 * Author: jwu049
 * Since: 2017/7/13 12:00
 */
class ImageErrorInfo
{
    const UPLOAD_FAILURE = -1;
    const TYPE_NOT_MATCH = -2;
    const SAVE_FAILURE = -3;

    public static $error_message = null;

    /**
     * 获取错误码对应的错误信息
     * @param  int $error_code 错误码
     * @return string 错误信息
     */
    public static function getErrorMsg($error_code)
    {
        if (is_null(self::$error_message)) {
            self::$error_message = self::get();
        }

        if (isset(self::$error_message[$error_code])) {
            return self::$error_message[$error_code];
        }

        return '';
    }

    public static function get()
    {
        return [
            self::UPLOAD_FAILURE => '图片上传失败！',
            self::TYPE_NOT_MATCH => '图片类型不匹配！',
            self::SAVE_FAILURE => '图片保存失败！',
        ];
    }
}
