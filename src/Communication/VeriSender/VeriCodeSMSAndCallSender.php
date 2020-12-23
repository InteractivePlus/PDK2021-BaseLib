<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021\User\UserInfo\UserEntity;

interface VeriCodeSMSAndCallSender extends VeriCodeCommonSender {
    public function sendVerifyPhoneNum(VeriCodeEntity $codeEntity, UserEntity $user, $destination);
}