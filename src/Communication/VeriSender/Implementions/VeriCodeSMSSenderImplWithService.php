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
use libphonenumber\PhoneNumber;

class VeriCodeSMSSenderImplWithService extends VeriCodePhoneSender{
    private SMSServiceProvider $_provider;
    private VeriCodeSMSAndCallContentGenerator $_contentGenerator;
    public ?string $messageSuffix = null;

    public function __construct(SMSServiceProvider $provider, VeriCodeSMSAndCallContentGenerator $contentGenerator, ?string $messageSuffix){
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

    public function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForImportantAction($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePassword($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForForgetPassword($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newEmail) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangeEmail($codeEntity,$user, $newEmail);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination, string $newPhoneNum) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePhone($codeEntity,$user,$newPhoneNum);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForAdminAction($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPImportantAction($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPDeleteAction($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    public function sendVerifyPhone(VeriCodeEntity $codeEntity, UserEntity $user, PhoneNumber $destination): void
    {
        $renderedContent = $this->_contentGenerator->getContentForPhoneVerification($codeEntity,$user);
        $this->sendSMS($destination,$renderedContent);
    }

    protected function sendSMS(PhoneNumber $destination, string $content) : void{
        $this->_provider->sendSMS($destination, $content . (empty($this->messageSuffix) ? '' : $this->messageSuffix),false);
    }
}