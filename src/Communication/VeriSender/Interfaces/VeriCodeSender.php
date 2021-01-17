<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces;

use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;

interface VeriCodeSender{
    public function sendVeriCode(VeriCodeEntity $veriCode, UserEntity $user, $destination) : void;
}