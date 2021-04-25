<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeID;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeIDs;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;
use InteractivePlus\PDK2021Core\APP\APPInfo\APPEntity;
use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenEntity;
use InteractivePlus\PDK2021Core\APP\MaskID\MaskIDEntity;

abstract class VeriCodeEmailSender implements VeriCodeSender{
    public abstract function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, string $newEmail, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, string $newPhoneNum, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendVerifyEmail(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void;

    public abstract function sendThirdAPPNotification(UserEntity $user, MaskIDEntity $maskID, APPEntity $appEntity, APPTokenEntity $appToken, $destination, string $notificationTitle, string $notificationContent, ?string $locale = LOCALE::LOCALE_en_US) : void;

    public abstract function sendThirdAPPSaleMsg(UserEntity $user, MaskIDEntity $maskID, APPEntity $appEntity, APPTokenEntity $appToken, $destination, string $notificationTitle, string $notificationContent, ?string $locale = LOCALE::LOCALE_en_US) : void;

    public function sendVeriCode(VeriCodeEntity $veriCode, UserEntity $user, $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        switch($veriCode->getVeriCodeID()->getVeriCodeID()){
            case VeriCodeIDs::VERICODE_VERIFY_EMAIL()->getVeriCodeID():
                $this->sendVerifyEmail($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_IMPORTANT_ACTION()->getVeriCodeID():
                $this->sendImportantAction($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_CHANGE_PASSWORD()->getVeriCodeID():
                $this->sendChangePassword($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_FORGET_PASSWORD()->getVeriCodeID():
                $this->sendForgotPassword($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_CHANGE_EMAIL()->getVeriCodeID():
                $this->sendChangeEmail($veriCode,$user,$destination,$veriCode->getVeriCodeParam('new_email'),$locale);
                break;
            case VeriCodeIDs::VERICODE_CHANGE_PHONE()->getVeriCodeID():
                $this->sendChangePhone($veriCode,$user,$destination,$veriCode->getVeriCodeParam('new_phone'),$locale);
                break;
            case VeriCodeIDs::VERICODE_ADMIN_ACTION()->getVeriCodeID():
                $this->sendAdminAction($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_THIRD_APP_IMPORTANT_ACTION()->getVeriCodeID():
                $this->sendThirdAPPImportantAction($veriCode,$user,$destination,$locale);
                break;
            case VeriCodeIDs::VERICODE_THIRD_APP_DELETE_ACTION()->getVeriCodeID():
                $this->sendThirdAPPDeleteAction($veriCode,$user,$destination,$locale);
                break;
            default:
                throw new PDKInnerArgumentError('veriCode','This vericode ID is not recognized by the specific sender');
        }
    }
}