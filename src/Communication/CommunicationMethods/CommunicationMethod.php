<?php
namespace InteractivePlus\PDK2021\Communication\CommunicationMethods;
class CommunicationMethod{
    const EMAIL = 1;
    const SMS_MESSAGE = 2;
    const PHONE_CALL = 4;
    const EMAIL_AND_SMS = self::EMAIL | self::SMS_MESSAGE; //3
    const SMS_AND_CALL = self::SMS_MESSAGE | self::PHONE_CALL; //6
    const EMAIL_AND_CALL = self::EMAIL | self::PHONE_CALL; //5
    const ALL = self::EMAIL | self::SMS_MESSAGE | self::PHONE_CALL; //7
    public static function isCommunicationMethodValid(int $commMethod) : bool{
        $reflectionForClass = new \ReflectionClass(__CLASS__);
        $allConstants = $reflectionForClass->getConstants();
        foreach($allConstants as $constantKey=>$constantVal){
            if($commMethod == $constantVal){
                return true;
            }
        }
        return false;
    }
}