<?php
namespace InteractivePlus\PDK2021\Communication\CommunicationMethods;
class SentMethod{
    const NOT_SENT = 0;
    const EMAIL = 1;
    const SMS_MESSAGE = 2;
    const PHONE_CALL = 4;
    public static function isSentMethodValid(int $sentMethod) : bool{
        $reflectionForClass = new \ReflectionClass(__CLASS__);
        $allConstants = $reflectionForClass->getConstants();
        foreach($allConstants as $constantKey=>$constantVal){
            if($sentMethod == $constantVal){
                return true;
            }
        }
        return false;
    }
}