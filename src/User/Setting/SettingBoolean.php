<?php
namespace InteractivePlus\PDK2021Core\User\Setting;
class SettingBoolean{
    const SET_YES = 1;
    const SET_NO = 0;
    const INHERIT = 2;
    public static function isValidSetting(int $set) : bool{
        return $set >= 0 and $set <= 2;
    }
    public static function fixSetting(int $set) : int{
        if(self::isValidSetting($set)){
            return $set;
        }else{
            return self::INHERIT;
        }
    }
    public static function toBoolean(int $set) : bool{
        return $set === self::SET_YES;
    }
}