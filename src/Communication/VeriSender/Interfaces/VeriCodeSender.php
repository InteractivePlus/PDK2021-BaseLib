<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces;

use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;

interface VeriCodeSender{
    public function sendVeriCode(VeriCodeEntity $veriCode, UserEntity $user, $destination, ?string $locale = Locale::LOCALE_en_US) : void;
}