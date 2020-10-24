<?php
namespace InteractivePlus\PDK2021\Communication\VerificationCode;
class VeriCodeID{
    const VERICODE_VERIFY_EMAIL = 10001;
    const VERICODE_VERIFY_PHONE = 10002;
    const VERICODE_IMPORTANT_ACTION = 10010;
    const VERICODE_CHANGE_PASSWORD = 20001;
    const VERICODE_FORGET_PASSWORD = 20002;
    const VERICODE_CHANGE_EMAIL = 20003;
    const VERICODE_CHANGE_PHONE = 20004;
    const VERICODE_ADMIN_ACTION = 30001;
    const VERICODE_THIRD_APP_IMPORTANT_ACTION = 90010;
    const VERICODE_THIRD_APP_DELETE_ACTION = 90050;
    public static function isValidVeriCodeID(int $veriCodeID) : bool{
        $reflectionForClass = new \ReflectionClass(__CLASS__);
        $allConstants = $reflectionForClass->getConstants();
        foreach($allConstants as $constantKey=>$constantVal){
            if($veriCodeID == $constantVal){
                return true;
            }
        }
        return false;
    }
}