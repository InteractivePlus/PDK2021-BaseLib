<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Implementions\EmailTemplateContent;
interface TemplateProvider{
    public function getNormalTemplate(?string $locale = null) : string;
    public function getNormalSafeTemplate(?string $locale = null) : string;
    public function getURLTemplate(?string $locale = null) : string;
    public function getURLSafeTemplate(?string $locale = null) : string;
}