<?php
namespace InteractivePlus\PDK2021\Communication\VerificationCode;

use InteractivePlus\PDK2021\Communication\CommunicationMethods\CommunicationMethod;

class VeriCodeProperties{
    const propertyMap = array(
        VeriCodeID::VERICODE_VERIFY_EMAIL => new VeriCodeProperty(false,true,CommunicationMethod::EMAIL,false,null,null),
        VeriCodeID::VERICODE_VERIFY_PHONE => new VeriCodeProperty(false,true,CommunicationMethod::SMS_AND_CALL,false,null),
        VeriCodeID::VERICODE_IMPORTANT_ACTION => new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null),
        VeriCodeID::VERICODE_CHANGE_PASSWORD => new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null),
        VeriCodeID::VERICODE_FORGET_PASSWORD => new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null),
        VeriCodeID::VERICODE_CHANGE_EMAIL => new VeriCodeProperty(false,true,CommunicationMethod::ALL,true,array('new_email'),null),
        VeriCodeID::VERICODE_CHANGE_PHONE => new VeriCodeProperty(false,false,CommunicationMethod::ALL,true, array('new_phone'),null),
        VeriCodeID::VERICODE_ADMIN_ACTION => new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null),
        VeriCodeID::VERICODE_THIRD_APP_IMPORTANT_ACTION => new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null),
        VeriCodeID::VERICODE_THIRD_APP_DELETE_ACTION => new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null)
    );
    public static function getProperty(int $veriCodeID) : ?VeriCodeProperty{
        return self::propertyMap[$veriCodeID];
    }
}