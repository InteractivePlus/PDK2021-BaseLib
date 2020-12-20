<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;

interface VeriCodeEmailSender extends VeriCodeCommonSender{
    public function sendVerifyEmail(VeriCodeEntity $codeEntity, $destination);
}