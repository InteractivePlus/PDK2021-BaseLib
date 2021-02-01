<?php
namespace InteractivePlus\PDK2021Core\APP\APPInfo;
class PDKAPPType{
    public const HAS_BACKEND = 1;
    public const NO_BACKEND = 2;
    public const EITHER = 3;
    public static function isValidAppType(int $type) : bool{
        if($type >= 1 && $type <= 3){
            return true;
        }else{
            return false;
        }
    }
    public static function fixAppType(int $type) : int{
        if(!self::isValidAppType($type)){
            return self::HAS_BACKEND;
        }else{
            return $type;
        }
    }
}