<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationMethods;

use InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces\EmailContent;

abstract class EmailServiceProvider{
    public abstract function addToAccount(string $address, ?string $name = null) : void;
    public abstract function addCCAccount(string $address, ?string $name = null) : void;
    public abstract function addBccAccount(string $address, ?string $name = null) : void;
    public abstract function clearToAccount() : void;
    public abstract function clearCCAcount() : void;
    public abstract function clearBccAccount() : void;
    public abstract function setSubject(?string $subject = null) : void;
    public abstract function setBody(?string $body = null) : void;
    public abstract function addEmbeddedImageAsAttachment(string $string, string $cid, ?string $fileName = null, ?string $mimeType = null) : void;
    public abstract function addAttachment(string $string, string $fileName, ?string $mimeType = null) : void;
    public abstract function clearAttachments() : void;
    public abstract function setFromName(?string $fromName = null) : void;
    public abstract function setFromEmail(?string $fromEmail = null) : void;
    public abstract function setCharset(string $charset = 'UTF-8') : void;
    public function clear(){
        $this->clearToAccount();
        $this->clearCCAcount();
        $this->clearBccAccount();
        $this->setSubject();
        $this->setBody();
        $this->clearAttachments();
        $this->setFromEmail();
        $this->setFromName();
    }
    public abstract function send() : bool;
}