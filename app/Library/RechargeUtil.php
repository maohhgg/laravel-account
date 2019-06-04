<?php


namespace App\Library;


class RechargeUtil
{
    /**
     * 将参数数组签名
     * @param array $array
     * @param $appkey
     * @return string
     */
    public static function SignArray(array $array, $appkey)
    {
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        ksort($array);
        $blankStr = RechargeUtil::ToUrlParams($array);
        $sign = md5($blankStr);
        return $sign;
    }

    public static function ToUrlParams(array $array)
    {
        $buff = "";
        foreach ($array as $k => $v) {
            if ($v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 校验签名
     * @param array 参数
     * @param string appkey
     * @return bool
     */
    public static function ValidSign(array $array, $appkey)
    {
        $sign = $array['sign'];
        unset($array['sign']);
        $array['key'] = $appkey;
        $mySign = RechargeUtil::SignArray($array, $appkey);
        return strtolower($sign) == strtolower($mySign);
    }


}