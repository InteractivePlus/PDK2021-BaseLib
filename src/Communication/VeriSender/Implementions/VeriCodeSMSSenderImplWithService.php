<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Implementions;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKSenderServiceError;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\VeriCodeEmailContentGenerator;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\VeriCodeSMSAndCallContentGenerator;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\EmailServiceProvider;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\SMSServiceProvider;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces\VeriCodeEmailSender;
use InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces\VeriCodePhoneSender;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;
use InteractivePlus\LibI18N\MultiLangValueProvider;
use libphonenumber\PhoneNumber;

class VeriCodeSMSSenderImplWithService extends VeriCodePhoneSender{
    private SMSServiceProvider $_provider;
    private VeriCodeSMSAndCallContentGenerator $_contentGenerator;
    public ?MultiLangValueProvider $messageSuffix = null;

    public function __construct(SMSServiceProvider $provider, VeriCodeSMSAndCallContentGenerator $contentGenerator, ?MultiLangValueProvider $messageSuffix){
        $this->_provider = $provider;
        $this->_contentGenerator = $contentGenerator;
        $this->messageSuffix = $messageSuffix;
    }

    public function getServiceProvider() : SMSServiceProvider{
        return $this->_provider;
    }

    public function getContentGenerator() : VeriCodeSMSAndCallContentGenerator{
        return $this->_contentGenerator;
    }

    public function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForImportantAction($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePassword($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForForgetPassword($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newEmail, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangeEmail($codeEntity,$user, $newEmail,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newPhoneNum, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePhone($codeEntity,$user,$newPhoneNum,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForAdminAction($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPImportantAction($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPDeleteAction($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendVerifyPhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, ?string $locale = Locale::LOCALE_en_US): void
    {
        $renderedContent = $this->_contentGenerator->getContentForPhoneVerification($codeEntity,$user,$locale);
        $this->sendSMS($destination,$renderedContent);
    }

    protected function sendSMS(PhoneNumber $destination, string $content, ?string $locale = Locale::LOCALE_en_US) : void{
        $suffix = '';
        if($this->messageSuffix !== null){
            if(empty($locale)){
                $suffix = $this->messageSuffix->defaultValue;
            }else{
                $suffix = $this->messageSuffix->getBestFitValueFor($locale);
            }
            if(empty($suffix)){
                $suffix = '';
            }
        }
        $this->_provider->sendSMS($destination, $content . $suffix,false);
    }
}