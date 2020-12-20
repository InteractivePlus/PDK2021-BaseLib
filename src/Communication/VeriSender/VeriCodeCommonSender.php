<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;
use libphonenumber\PhoneNumber;

interface VeriCodeCommonSender{
    public function sendImportantAction(VeriCodeEntity $codeEntity, $destination) : void;

    public function sendChangePassword(VeriCodeEntity $codeEntity, $destination) : void;

    public function sendForgotPassword(VeriCodeEntity $codeEntity, $destination) : void;

    public function sendChangeEmail(VeriCodeEntity $codeEntity, $destination, string $newEmail) : void;

    public function sendChangePhone(VeriCodeEntity $codeEntity, $destination, PhoneNumber $newPhoneNum) : void;

    public function sendAdminAction(VeriCodeEntity $codeEntity, $destination) : void;

    public function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, $destination) : void;

    public function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, $destination) : void;
}