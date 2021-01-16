<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\CommunicationMethod;

class VeriCodeID{
    const VERICODE_VERIFY_EMAIL = new VeriCodeID(10001,new VeriCodeProperty(false,true,CommunicationMethod::EMAIL,false,null,null));
    const VERICODE_VERIFY_PHONE = new VeriCodeID(10002,new VeriCodeProperty(false,true,CommunicationMethod::SMS_AND_CALL,false,null));
    const VERICODE_IMPORTANT_ACTION = new VeriCodeID(10010,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
    const VERICODE_CHANGE_PASSWORD = new VeriCodeID(20001,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
    const VERICODE_FORGET_PASSWORD = new VeriCodeID(20002,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
    const VERICODE_CHANGE_EMAIL = new VeriCodeID(20003,new VeriCodeProperty(false,true,CommunicationMethod::ALL,true,array('new_email'),null));
    const VERICODE_CHANGE_PHONE = new VeriCodeID(20004,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true, array('new_phone'),null));
    const VERICODE_ADMIN_ACTION = new VeriCodeID(30001,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null));
    const VERICODE_THIRD_APP_IMPORTANT_ACTION = new VeriCodeID(90010,new VeriCodeProperty(true,false,CommunicationMethod::ALL,true,null,null));
    const VERICODE_THIRD_APP_DELETE_ACTION = new VeriCodeID(90050,new VeriCodeProperty(false,false,CommunicationMethod::ALL,true,null,null));

    public static function isValidVeriCodeID(int $veriCodeID) : bool{
        $reflectionForClass = new \ReflectionClass(__CLASS__);
        $allConstants = $reflectionForClass->getConstants();
        foreach($allConstants as $constantKey=>$constantVal){
            if($veriCodeID == $constantVal->getVeriCodeID()){
                return true;
            }
        }
        return false;
    }

    public static function findVeriCodeID(int $veriCodeID) : ?VeriCodeID{
        $reflectionForClass = new \ReflectionClass(__CLASS__);
        $allConstants = $reflectionForClass->getConstants();
        foreach($allConstants as $constantKey=>$constantVal){
            if($veriCodeID == $constantVal->getVeriCodeID()){
                return $constantVal;
            }
        }
        return null;
    }


    private int $veriCodeID = 0;
    private VeriCodeProperty $veriCodeProperty = null;
    public function __construct(int $veriCodeID, VeriCodeProperty $veriCodeProperty){
        $this->veriCodeID = $veriCodeID;
        $this->veriCodeProperty = $veriCodeProperty;
    }
    public function getVeriCodeID() : int{
        return $this->veriCodeID;
    }
    public function getProperty() : VeriCodeProperty{
        return $this->veriCodeProperty;
    }
    
}