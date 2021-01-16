<?php
namespace InteractivePlus\PDK2021Core;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Logger\LoggerStorage;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\SentMethod;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeStorage;
use InteractivePlus\PDK2021Core\Communication\VeriSender\VeriCodeEmailSender;
use InteractivePlus\PDK2021Core\Communication\VeriSender\VeriCodeSMSAndCallSender;
use InteractivePlus\PDK2021Core\User\Login\TokenEntityStorage;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntityStorage;

class PDKCore{
    private LoggerStorage $_logger;
    private VeriCodeStorage $_veriCodeStorage;
    private ?VeriCodeEmailSender $_veriCodeEmailSender;
    private ?VeriCodeSMSAndCallSender $_veriCodeSMSSender;
    private ?VeriCodeSMSAndCallSender $_veriCodeCallSender;
    private UserEntityStorage $_userEntityStorage;
    private TokenEntityStorage $_tokenEntityStorage;

    public function __construct(
        LoggerStorage $logger,
        VeriCodeStorage $veriCodeStorage,
        ?VeriCodeEmailSender $veriCodeEmailSender,
        ?VeriCodeSMSAndCallSender $veriCodeSMSSender,
        ?VeriCodeSMSAndCallSender $veriCodeCallSender,
        UserEntityStorage $userEntityStorage,
        TokenEntityStorage $tokenEntityStorage
    ){
        if($veriCodeEmailSender === null && $veriCodeSMSSender === null && $veriCodeCallSender === null){
            throw new PDKInnerArgumentError('veriCodeEmailSender|veriCodeSMSSender|veriCodeCallSender','There should be at least one vericode sender that is not null');
        }
        $this->_logger = $logger;
        $this->_veriCodeStorage = $veriCodeStorage;
        $this->_veriCodeEmailSender = $veriCodeEmailSender;
        $this->_veriCodeSMSSender = $veriCodeSMSSender;
        $this->_veriCodeCallSender = $veriCodeCallSender;
        $this->_userEntityStorage = $userEntityStorage;
        $this->_tokenEntityStorage = $tokenEntityStorage;
    }

    public function getLogger() : LoggerStorage{
        return $this->_logger;
    }

    public function getVeriCodeStorage() : VeriCodeStorage{
        return $this->_veriCodeStorage;
    }

    public function isVeriCodeEmailSenderAvailable() : bool{
        return $this->_veriCodeEmailSender === null;
    }

    public function isVeriCodeSMSSenderAvailable() : bool{
        return $this->_veriCodeSMSSender === null;
    }

    public function isVeriCodeCallSenderAvailable() : bool{
        return $this->_veriCodeCallSender === null;
    }

    public function canUsePhoneRegister() : bool{
        return $this->isVeriCodeSMSSenderAvailable() || $this->isVeriCodeCallSenderAvailable();
    }

    public function getVeriCodeEmailSender() : ?VeriCodeEmailSender{
        return $this->_veriCodeEmailSender;
    }

    public function getVeriCodeSMSSender() : ?VeriCodeSMSAndCallSender{
        return $this->_veriCodeSMSSender;
    }

    public function getVeriCodeCallSender() : ?VeriCodeSMSAndCallSender{
        return $this->_veriCodeCallSender;
    }
    public function getPhoneSender(int &$methodReceiver, bool $preferSMS = true) : ?VeriCodeSMSAndCallSender{
        if($preferSMS && $this->_veriCodeSMSSender !== null){
            $methodReceiver = SentMethod::SMS_MESSAGE;
            return $this->_veriCodeSMSSender;
        }else if($this->_veriCodeCallSender !== null){
            $methodReceiver = SentMethod::PHONE_CALL;
            return $this->_veriCodeCallSender;
        }else{
            $methodReceiver = SentMethod::NOT_SENT;
            return null;
        }
    }
    public function getUserEntityStorage() : UserEntityStorage{
        return $this->_userEntityStorage;
    }
    public function getTokenEntityStorage() : TokenEntityStorage{
        return $this->_tokenEntityStorage;
    }
}