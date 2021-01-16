<?php
namespace InteractivePlus\PDK2021Core\Base\Formats;
class IPFormat{
    public static function isIP(string $ip) : bool {
        if (filter_var($ip,\FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }
    public static function isIPV4(string $ip) : bool {
        if (filter_var($ip,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV4)) {
            return true;
        } else {
            return false;
        }
    }
    public static function isIPV6(string $ip) : bool{
        if (filter_var($ip,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV6)) {
            return true;
        } else {
            return false;
        }
    }
    public static function formatIP(string $IP) : string{
        $transformedVal = inet_ntop(inet_pton($IP));
        if($transformedVal === false){
            $transformedVal = $IP;
        }
        return strtolower($transformedVal);
    }

    public static function ipAddressEquals(string $ip1, string $ip2) : bool{
        $ip1Byte = inet_pton($ip1);
        $ip2Byte = inet_pton($ip2);
        if($ip1Byte === false || $ip2Byte === false){
            return false;
        }
        return $ip1Byte == $ip2Byte;
    }
}