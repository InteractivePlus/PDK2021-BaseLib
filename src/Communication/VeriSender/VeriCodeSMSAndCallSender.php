<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender;

use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;

interface VeriCodeSMSAndCallSender extends VeriCodeCommonSender {
    public function sendVerifyPhoneNum(VeriCodeEntity $codeEntity, UserEntity $user, $destination) : void;
}