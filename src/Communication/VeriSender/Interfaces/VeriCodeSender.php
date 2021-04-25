<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces;

use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;
use InteractivePlus\PDK2021Core\APP\APPInfo\APPEntity;
use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenEntity;
use InteractivePlus\PDK2021Core\APP\MaskID\MaskIDEntity;

interface VeriCodeSender{
    public function sendVeriCode(VeriCodeEntity $veriCode, UserEntity $user, $destination, ?string $locale = Locale::LOCALE_en_US) : void;
    public function sendThirdAPPNotification(UserEntity $user, MaskIDEntity $maskID, APPEntity $appEntity, APPTokenEntity $appToken, $destination, string $notificationTitle, string $notificationContent, ?string $locale = LOCALE::LOCALE_en_US) : void;
    public function sendThirdAPPSaleMsg(UserEntity $user, MaskIDEntity $maskID, APPEntity $appEntity, APPTokenEntity $appToken, $destination, string $notificationTitle, string $notificationContent, ?string $locale = LOCALE::LOCALE_en_US) : void;
    public function supportsNotificationAndSalesMsg() : bool;
}