<?php
namespace InteractivepLus\PDK2021\Communication\CommunicationContents\Interfaces;

use InteractivePlus\PDK2021\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021\User\UserInfo\UserEntity;

interface VeriCodeEmailContentGenerator{
    public function getContentForEmailVerification(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForChangePassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForForgetPassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForChangeEmail(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForChangePhone(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForAdminAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForThirdAPPImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
    public function getContentForThirdAPPDeleteAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent;
}