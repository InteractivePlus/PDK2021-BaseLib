<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Implementions\EmailTemplateContent;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;
use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\VeriCodeEmailContentGenerator;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use LibI18N\Comparison;
use LibI18N\Locale;

class TemplateContentGenerator implements VeriCodeEmailContentGenerator{
    private TemplateProvider $_tplProvider;
    private UserSystemLinkProvider $_linkProvider;

    private string $_systemName;

    public function __construct(TemplateProvider $templateProvider, UserSystemLinkProvider $linkProvider, string $systemName = 'InteractivePDK')
    {
        $this->_tplProvider = $templateProvider;
        $this->_linkProvider = $linkProvider;
        $this->_systemName = $systemName;
    }

    public function getContentForEmailVerification(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '验证邮箱';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Verifying Email';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $renderedURL = TemplateUtil::quickRender($this->_linkProvider->verifyEmailLink($locale),['veriCode'=>$veriCodeEntity->getVeriCodeString()]);
        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCodeLink' => $renderedURL,
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getURLSafeTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '进行重要操作';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Performing Important Action';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCode' => $veriCodeEntity->getVeriCodeString(),
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getNormalTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForChangePassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '修改密码';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Changing password';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCode' => $veriCodeEntity->getVeriCodeString(),
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getNormalTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForForgetPassword(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '进行密码重设';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Resetting password';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $renderedURL = TemplateUtil::quickRender($this->_linkProvider->forgotPasswordLink($locale),['veriCode'=>$veriCodeEntity->getVeriCodeString()]);
        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCodeLink' => $renderedURL,
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getURLTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForChangeEmail(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newEmail) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '更改密保邮箱';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Changing Email Address';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $renderedURL = TemplateUtil::quickRender($this->_linkProvider->changeEmailLink($locale),['veriCode'=>$veriCodeEntity->getVeriCodeString()]);
        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName . ' -> ' . $newEmail,
            'veriCodeLink' => $renderedURL,
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getURLTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForChangePhone(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser, string $newPhone) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '更改密保手机';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Changing Phone Number';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $renderedURL = TemplateUtil::quickRender($this->_linkProvider->forgotPasswordLink($locale),['veriCode'=>$veriCodeEntity->getVeriCodeString()]);
        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName . ' -> ' . $newPhone,
            'veriCodeLink' => $renderedURL,
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getURLTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForAdminAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '进行管理员操作';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Performing Admin Action';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCode' => $veriCodeEntity->getVeriCodeString(),
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getNormalTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForThirdAPPImportantAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '进行第三方APP重要操作';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Performing Important Action in 3rd-Party APP';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCode' => $veriCodeEntity->getVeriCodeString(),
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getNormalTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
    public function getContentForThirdAPPDeleteAction(VeriCodeEntity $veriCodeEntity, UserEntity $relatedUser) : EmailContent{
        $locale = 'zh-CN';
        $actionName = '';
        $subject = '';
        if(Locale::isLocaleCloseEnough($locale,'zh')){
            $actionName = '删除第三方APP';
            $subject = $this->_systemName . ' - ' . $actionName . '验证码';
        }else{
            $actionName = 'Deleting Third-party APP';
            $this->_systemName . ' - ' . $actionName . ' - Verification Code';
        }

        $templateArgs = [
            'userNickname' => empty($relatedUser->getNickName()) ? $relatedUser->getUsername() : $relatedUser->getNickName(),
            'actionName' => $actionName,
            'veriCode' => $veriCodeEntity->getVeriCodeString(),
            'userSystemName' => $this->_systemName
        ];
        
        $renderedTemplate = TemplateUtil::renderTemplate($this->_tplProvider->getNormalTemplate($locale),$templateArgs,true,true);
        return new EmailContent($subject,$renderedTemplate);
    }
}