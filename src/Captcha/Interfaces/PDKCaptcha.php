<?php
namespace InteractivePlus\PDK2021Core\Captcha\Interfaces;
class PDKCaptcha{
    private $_clientData;
    private string $_captchaID;
    private int $_expires;

    public function __construct(string $captchaID, $clientData, int $expires){
        $this->_captchaID = $captchaID;
        $this->_clientData = $clientData;
        $this->_expires = $expires;
    }

    public function getClientData(){
        return $this->_clientData;
    }
    public function getCaptchaID() : string{
        return $this->_captchaID;
    }

    public function getExpireUTCTime() : int{
        return $this->_expires;
    }

    public function toAssocArr() : array{
        return array(
            'captchaID' => $this->getCaptchaID(),
            'captchaClientData' => $this->getClientData(),
            'expire_time' => $this->getExpireUTCTime()
        );
    }
}