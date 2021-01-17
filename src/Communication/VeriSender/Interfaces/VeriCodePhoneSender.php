<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeID;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use libphonenumber\PhoneNumber;

abstract class VeriCodePhoneSender implements VeriCodeSender{
    public abstract function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newEmail) : void;

    public abstract function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newPhoneNum) : void;

    public abstract function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public abstract function sendVerifyPhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void;

    public function sendVeriCode(VeriCodeEntity $veriCode, UserEntity $user, $destination) : void{
        switch($veriCode->getVeriCodeID()->getVeriCodeID()){
            case VeriCodeID::VERICODE_VERIFY_PHONE->getVeriCodeID():
                $this->sendVerifyPhone($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_IMPORTANT_ACTION->getVeriCodeID():
                $this->sendImportantAction($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_CHANGE_PASSWORD->getVeriCodeID():
                $this->sendChangePassword($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_FORGET_PASSWORD->getVeriCodeID():
                $this->sendForgotPassword($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_CHANGE_EMAIL->getVeriCodeID():
                $this->sendChangeEmail($veriCode,$user,$destination,$veriCode->getVeriCodeParam('new_email'));
                break;
            case VeriCodeID::VERICODE_CHANGE_PHONE->getVeriCodeID():
                $this->sendChangePhone($veriCode,$user,$destination,$veriCode->getVeriCodeParam('new_phone'));
                break;
            case VeriCodeID::VERICODE_ADMIN_ACTION->getVeriCodeID():
                $this->sendAdminAction($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_THIRD_APP_IMPORTANT_ACTION->getVeriCodeID():
                $this->sendThirdAPPImportantAction($veriCode,$user,$destination);
                break;
            case VeriCodeID::VERICODE_THIRD_APP_DELETE_ACTION->getVeriCodeID():
                $this->sendThirdAPPDeleteAction($veriCode,$user,$destination);
                break;
            default:
                throw new PDKInnerArgumentError('veriCode','This vericode ID is not recognized by the specific sender');
        }
    }
}