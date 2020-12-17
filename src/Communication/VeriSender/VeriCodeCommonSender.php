<?php
namespace InteractivePlus\PDK2021\Communication\VeriSender;

use libphonenumber\PhoneNumber;

interface VeriCodeCommonSender{
    public function sendImportantAction($destination) : void;

    public function sendChangePassword($destination) : void;

    public function sendForgotPassword($destination) : void;

    public function sendChangeEmail($destination, string $newEmail) : void;

    public function sendChangePhone($destination, PhoneNumber $newPhoneNum) : void;

    public function sendAdminAction($destination) : void;

    public function sendThirdAPPImportantAction($destination) : void;

    public function sendThirdAPPDeleteAction($destination) : void;
}