<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces;

use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;

interface VeriCodeEmailContentGenerator{
    public function getContentForEmailVerification(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForChangePassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForForgetPassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForChangeEmail(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newEmail, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForChangePhone(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newPhone, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForAdminAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForThirdAPPImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
    public function getContentForThirdAPPDeleteAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, ?string $locale = Locale::LOCALE_en_US) : EmailContent;
}