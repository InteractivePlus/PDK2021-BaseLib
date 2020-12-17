<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;
interface VeriCodeSMSAndCallSender extends VeriCodeCommonSender {
    public function sendVerifyPhoneNum($destination);
}