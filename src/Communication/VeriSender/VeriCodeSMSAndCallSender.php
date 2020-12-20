<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;

interface VeriCodeSMSAndCallSender extends VeriCodeCommonSender {
    public function sendVerifyPhoneNum(VeriCodeEntity $codeEntity, $destination);
}