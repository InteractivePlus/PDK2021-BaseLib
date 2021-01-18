<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;

use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\CommunicationMethod;

class VeriCodeIDs{
    public static function isValidVeriCodeID(int $veriCodeID) : bool{
        $list = self::getVeriCodeList();
        foreach($list as $singleVeriCode){
            if($singleVeriCode->getVeriCodeID() === $veriCodeID){
                return true;
            }
        }
        return false;
    }

    public static function findVeriCodeID(int $veriCodeID) : ?VeriCodeID{
        $list = self::getVeriCodeList();
        foreach($list as $singleVeriCode){
            if($singleVeriCode->getVeriCodeID() === $veriCodeID){
                return $singleVeriCode;
            }
        }
        return null;
    }

    public static function getVeriCodeList() : array{
        return array(
            self::VERICODE_VERIFY_EMAIL(),
            self::VERICODE_VERIFY_PHONE(),
            self::VERICODE_IMPORTANT_ACTION(),
            self::VERICODE_CHANGE_PASSWORD(),
            self::VERICODE_FORGET_PASSWORD(),
            self::VERICODE_CHANGE_EMAIL(),
            self::VERICODE_CHANGE_PHONE(),
            self::VERICODE_ADMIN_ACTION(),
            self::VERICODE_THIRD_APP_IMPORTANT_ACTION(),
            self::VERICODE_THIRD_APP_DELETE_ACTION()
        );
    }

    private static ?VeriCodeID $_VERICODE_VERIFY_EMAIL = null;
    public static function VERICODE_VERIFY_EMAIL() : VeriCodeID{
        if(self::$_VERICODE_VERIFY_EMAIL === null){
            self::$_VERICODE_VERIFY_EMAIL = new VeriCodeID(10001,new VeriCodeProperty(false,true,CommunicationMethod::EMAIL,false,null,null));
        }
        return self::$_VERICODE_VERIFY_EMAIL;
    }

    private static ?VeriCodeID $_VERICODE_VERIFY_PHONE = null;
    public static function VERICODE_VERIFY_PHONE() : VeriCodeID{
        if(self::$_VERICODE_VERIFY_PHONE === null){
            self::$_VERICODE_VERIFY_PHONE = new VeriCodeID(10002,new VeriCodeProperty(false,true,CommunicationMethod::SMS_AND_CALL,false,null));
        }
        return self::$_VERICODE_VERIFY_PHONE;
    }

    private static ?VeriCodeID $_VERICODE_IMPORTANT_ACTION = null;
    public static function VERICODE_IMPORTANT_ACTION() : VeriCodeID{
        if(self::$_VERICODE_IMPORTANT_ACTION === null){
            self::$_VERICODE_IMPORTANT_ACTION = new VeriCodeID(10010,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_IMPORTANT_ACTION;
    }

    private static ?VeriCodeID $_VERICODE_CHANGE_PASSWORD = null;

    public static function VERICODE_CHANGE_PASSWORD() : VeriCodeID{
        if(self::$_VERICODE_CHANGE_PASSWORD === null){
            self::$_VERICODE_CHANGE_PASSWORD = new VeriCodeID(20001,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_CHANGE_PASSWORD;
    }

    private static ?VeriCodeID $_VERICODE_FORGET_PASSWORD = null;
    public static function VERICODE_FORGET_PASSWORD() : VeriCodeID{
        if(self::$_VERICODE_FORGET_PASSWORD === null){
            self::$_VERICODE_FORGET_PASSWORD = new VeriCodeID(20002,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_FORGET_PASSWORD;
    }

    private static ?VeriCodeID $_VERICODE_CHANGE_EMAIL = null;
    public static function VERICODE_CHANGE_EMAIL() : VeriCodeID{
        if(self::$_VERICODE_CHANGE_EMAIL === null){
            self::$_VERICODE_CHANGE_EMAIL = new VeriCodeID(20003,new VeriCodeProperty(false,true,CommunicationMethod::ALL,true,array('new_email'),null));
        }
        return self::$_VERICODE_CHANGE_EMAIL;
    }

    private static ?VeriCodeID $_VERICODE_CHANGE_PHONE = null;
    public static function VERICODE_CHANGE_PHONE() : VeriCodeID{
        if(self::$_VERICODE_CHANGE_PHONE === null){
            self::$_VERICODE_CHANGE_PHONE = new VeriCodeID(20004,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true, array('new_phone'),null));
        }
        return self::$_VERICODE_CHANGE_PHONE;
    }


    private static ?VeriCodeID $_VERICODE_ADMIN_ACTION = null;
    public static function VERICODE_ADMIN_ACTION() : VeriCodeID{
        if(self::$_VERICODE_ADMIN_ACTION === null){
            self::$_VERICODE_ADMIN_ACTION = new VeriCodeID(30001,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_ADMIN_ACTION;
    }
    
    private static ?VeriCodeID $_VERICODE_THIRD_APP_IMPORTANT_ACTION = null;
    public static function VERICODE_THIRD_APP_IMPORTANT_ACTION() : VeriCodeID{
        if(self::$_VERICODE_THIRD_APP_IMPORTANT_ACTION === null){
            self::$_VERICODE_THIRD_APP_IMPORTANT_ACTION = new VeriCodeID(90010,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_THIRD_APP_IMPORTANT_ACTION;
    }

    private static ?VeriCodeID $_VERICODE_THIRD_APP_DELETE_ACTION = null;
    public static function VERICODE_THIRD_APP_DELETE_ACTION() : VeriCodeID{
        if(self::$_VERICODE_THIRD_APP_DELETE_ACTION === null){
            self::$_VERICODE_THIRD_APP_DELETE_ACTION = new VeriCodeID(90050,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null));
        }
        return self::$_VERICODE_THIRD_APP_DELETE_ACTION;
    }
}