<?php
namespace InteractivePlus\PDK2021Core\Communication\VeriSender\Implementions;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKSenderServiceError;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\VeriCodeEmailContentGenerator;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\EmailServiceProvider;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces\VeriCodeEmailSender;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\LibI18N\Locale;
use InteractivePlus\LibI18N\MultiLangValueProvider;

class VeriCodeEmailSenderImplWithProvider extends VeriCodeEmailSender{
    private EmailServiceProvider $_provider;
    private VeriCodeEmailContentGenerator $_contentGenerator;
    public ?MultiLangValueProvider $fromName;
    public ?string $fromEmail;

    public function __construct(EmailServiceProvider $provider, VeriCodeEmailContentGenerator $contentGenerator, ?MultiLangValueProvider $fromName = null, ?string $fromEmail = null){
        $this->_provider = $provider;
        $this->_contentGenerator = $contentGenerator;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
    }

    public function getServiceProvider() : EmailServiceProvider{
        return $this->_provider;
    }

    public function getContentGenerator() : VeriCodeEmailContentGenerator{
        return $this->_contentGenerator;
    }

    public function sendImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForImportantAction($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendChangePassword(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePassword($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendForgotPassword(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForForgetPassword($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendChangeEmail(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, string $newEmail, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangeEmail($codeEntity,$user, $newEmail);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendChangePhone(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, string $newPhoneNum, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForChangePhone($codeEntity,$user,$newPhoneNum);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendAdminAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForAdminAction($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendThirdAPPImportantAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPImportantAction($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendThirdAPPDeleteAction(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForThirdAPPDeleteAction($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    public function sendVerifyEmail(VeriCodeEntity $codeEntity, UserEntity $user, string $destination, ?string $locale = Locale::LOCALE_en_US) : void{
        $renderedContent = $this->_contentGenerator->getContentForEmailVerification($codeEntity,$user);
        $this->sendEmail($destination,$user->getNickName(),$renderedContent,$locale);
    }

    protected function sendEmail(string $destination, ?string $destinationName = null, EmailContent $content, ?string $locale = Locale::LOCALE_en_US) : void{

        $fromName = null;
        if($this->fromName !== null){
            if(empty($locale)){
                $fromName = $this->fromName->defaultValue;
            }else{
                $fromName = $this->fromName->getBestFitValueFor($locale);
            }
            if(empty($fromName)){
                $fromName = null;
            }
        }

        $this->_provider->clear();
        $this->_provider->addToAccount($destination,empty($destinationName) ? null : $destinationName);
        $this->_provider->setFromEmail(empty($this->fromEmail) ? null : $this->fromEmail);
        $this->_provider->setFromName($fromName);
        $this->_provider->setCharset($content->getCharset());
        $this->_provider->setSubject($content->getTitle());
        $this->_provider->setBody($content->getContent());
        $sendResult = $this->_provider->send();
        if(!$sendResult){
            throw new PDKSenderServiceError('failed to send email to specified account');
        }
    }
}