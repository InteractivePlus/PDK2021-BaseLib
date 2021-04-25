<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Implementions\EmailTemplateContent;
interface EmailTemplateProvider{
    public function getNormalTemplate(?string $locale = null) : string;
    public function getNormalSafeTemplate(?string $locale = null) : string;
    public function getURLTemplate(?string $locale = null) : string;
    public function getURLSafeTemplate(?string $locale = null) : string;
    public function getOAuthNotificationTemplate(?string $locale = null) : string;
    public function getOAuthSaleMsgTemplate(?string $locale = null) : string;
}