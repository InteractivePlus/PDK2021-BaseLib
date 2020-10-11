<?php
namespace InteractivePlus\PDK2021Base\Formats;
class IPFormat{
    public static function isIP($ip) : bool {
        if (filter_var($ip,\FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }
    public static function isIPV4($ip) : bool {
        if (filter_var($ip,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV4)) {
            return true;
        } else {
            return false;
        }
    }
    public static function isIPV6($ip) : bool{
        if (filter_var($ip,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV6)) {
            return true;
        } else {
            return false;
        }
    }
}