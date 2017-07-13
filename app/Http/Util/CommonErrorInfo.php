<?php
namespace App\Http\Util;

/**
 * Created by PhpStorm.
 * Author: jwu049
 * Since: 2017/7/13 12:00
 */
class CommonErrorInfo
{
    const SUCCESS = 0;
    const ERROR_URL = 1001;

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
            self::SUCCESS => '成功',
            self::ERROR_URL => '参数错误',
        ];
    }
}
