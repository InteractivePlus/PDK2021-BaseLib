<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces;

use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;
use InteractivePlus\PDK2021Core\APP\APPInfo\APPEntity;
use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenEntity;
use InteractivePlus\PDK2021Core\APP\MaskID\MaskIDEntity;

interface VeriCodeEmailContentGenerator{
    public function getContentForEmailVerification(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForChangePassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForForgetPassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForChangeEmail(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newEmail, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForChangePhone(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newPhone, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForAdminAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForThirdAPPImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForThirdAPPDeleteAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForThirdAPPNotification(UserEntity $relatedUser, MaskIDEntity $relatedMaskID, APPEntity $relatedAPP, APPTokenEntity $relatedAPPToken, string $notificationTitle, string $notificationContent, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
    public function getContentForThirdAPPSaleMsg(UserEntity $relatedUser, MaskIDEntity $relatedMaskID, APPEntity $relatedAPP, APPTokenEntity $relatedAPPToken, string $notificationTitle, string $notificationContent, ?string $locale = Locale::LOCALE_zh_Hans_CN) : EmailContent;
}