<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021\User\UserInfo\UserEntity;
use libphonenumber\PhoneNumber;

interface VeriCodeCommonSender{
    public function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;

    public function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;

    public function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;

    public function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, $destination, string $newEmail) : void;

    public function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, $destination, PhoneNumber $newPhoneNum) : void;

    public function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;

    public function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;

    public function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;
}