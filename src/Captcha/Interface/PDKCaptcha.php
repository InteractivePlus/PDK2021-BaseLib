<?php
namespace InteractivePlus\PDK2021Core\Captcha\Interface;
class PDKCaptcha{
    private $_clientData;
    private string $_captchaID;

    public function __construct(string $captchaID, $clientData){
        $this->_captchaID = $captchaID;
        $this->_clientData = $clientData;
    }

    public function getClientData(){
        return $this->_clientData;
    }
    public function getCaptchaID() : string{
        return $this->_captchaID;
    }

    public function toAssocArr() : array{
        return array(
            'captchaID' => $this->getCaptchaID(),
            'captchaClientData' => $this->getClientData()
        );
    }
}