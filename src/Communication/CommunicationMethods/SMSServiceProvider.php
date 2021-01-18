<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationMethods;

use libphonenumber\PhoneNumber;

interface SMSServiceProvider{
    public function sendSMS(PhoneNumber $numberToReceive, string $content, bool $enableSMSSplit) : bool;
}