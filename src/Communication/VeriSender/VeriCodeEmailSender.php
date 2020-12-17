<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;
interface VeriCodeEmailSender extends VeriCodeCommonSender{
    public function sendVerifyEmail($destination);
}