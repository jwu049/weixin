<?php
/**
 * Created by PhpStorm.
 * Author: jwu049
 * Since: 2017/7/13 12:54
 */

namespace App\Http\Util;


class ApiOutputTool
{
    public static $result;

    /**
     * 输出json
     * @param $res
     */
    public static function output($res)
    {
        $res = self::outputToString($res);
        echo json_encode($res);
        exit;
    }

    /**
     * 输出错误
     * @param $error_code
     * @param $error_msg
     */
    public static function outputError($error_code, $error_msg)
    {
        $result = [
            'status' => $error_code,
            'msg' => $error_msg ? $error_msg : ImageErrorInfo::getErrorMsg($error_code)
        ];

        $result = self::outputToString($result);
        echo json_encode($result);
        exit;
    }

    /**
     * 输出成功信息
     * @param $data
     * @param string $msg
     * @param int $request_time
     * @param bool $java_style
     */
    public static function outputData($data, $msg = '', $request_time=0, $java_style = false)
    {
        $result = array(
            'status' => CommonErrorInfo::SUCCESS,
            'msg' => $msg ? $msg : CommonErrorInfo::getErrorMsg(CommonErrorInfo::SUCCESS),
            'requestTime' => self::getRequestTime($request_time),
            'data' => $data,
        );

        if ($java_style) {
            $result = self::outputToStringAnd2JavaStyle($result);
        } else {
            $result = self::outputToString($result);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * 将非字符串转成字符串
     * @param $params
     * @return array
     * author Fox
     */
    public static function outputToString($params)
    {
        if (empty($params) || (!is_array($params) && !is_object($params))) {
            return $params;
        }

        foreach ($params as $key => $v) {
            if (is_array($v) || is_object($v)) {
                $v = self::outputToString($v);
            } elseif (!is_bool($v)) {
                $v = $v . "";
            }

            if (is_array($params)) {
                $params[$key] = $v;
            } elseif (is_object($params)) {
                $params->$key = $v;
            }
        }
        return $params;
    }

    public static function doParamError()
    {
        self::$result['status'] = CommonErrorInfo::ERROR_URL;
        self::$result['msg'] = CommonErrorInfo::getErrorMsg(CommonErrorInfo::ERROR_URL);

        echo json_encode(self::$result);

        return false;
    }

    /**
     * 返回时间戳
     * @return float
     */
    public static function getTimestamp()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    /**
     * 返回时间戳
     * @param $request_time
     * @return float
     */
    public static function getRequestTime($request_time)
    {
        return self::getTimestamp() - $request_time;
    }

    /**
     * 统一出参格式化为字符串 and 出参字段转为驼峰样式
     * @param $params
     * @return array|\stdClass
     */
    public static function outputToStringAnd2JavaStyle($params)
    {
        if (empty($params) || (!is_array($params) && !is_object($params))) {
            return $params;
        }

        if (is_array($params)) {
            $format_result = [];
        } else {
            $format_result = new \stdClass();
        }
        foreach ($params as $key => $v) {
            if (is_array($v) || is_object($v)) {
                $v = self::outputToStringAnd2JavaStyle($v);
            } elseif (!is_bool($v)) {
                $v = $v . "";
            }

            $key = self::convertJavaStyle($key);
            if (is_array($params)) {
                $format_result[$key] = $v;
            } elseif (is_object($params)) {
                $format_result->$key = $v;
            }
        }
        return $format_result;
    }

    public static function convertJavaStyle($key)
    {
        $rs = preg_replace_callback(
            "/(?:^|_)([a-z])/",
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $key
        );
        return preg_replace_callback(
            "#^(.)#",
            function ($matches) {
                return strtolower($matches[1]);
            },
            $rs
        );
    }

}