<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender;

use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;

interface VeriCodeEmailSender extends VeriCodeCommonSender{
    public function sendVerifyEmail(VeriCodeEntity $codeEntity, UserEntity $user, $destination);
}