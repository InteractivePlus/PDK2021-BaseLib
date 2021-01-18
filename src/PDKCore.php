<?php
namespace InteractivePlus\PDK2021Core;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKSenderServiceError;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;
use InteractivePlus\PDK2021Core\Base\Logger\LoggerStorage;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\SentMethod;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeEntity;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeIDs;
use InteractivePlus\PDK2021Core\Communication\VerificationCode\VeriCodeStorage;
use InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces\VeriCodeEmailSender;
use InteractivePlus\PDK2021Core\Communication\VeriSender\Interfaces\VeriCodePhoneSender;
use InteractivePlus\PDK2021Core\User\Login\TokenEntityStorage;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntityStorage;
use libphonenumber\PhoneNumber;

class PDKCore{
    private LoggerStorage $_logger;
    private VeriCodeStorage $_veriCodeStorage;
    private ?VeriCodeEmailSender $_veriCodeEmailSender;
    private ?VeriCodePhoneSender $_veriCodeSMSSender;
    private ?VeriCodePhoneSender $_veriCodeCallSender;
    private UserEntityStorage $_userEntityStorage;
    private TokenEntityStorage $_tokenEntityStorage;

    public function __construct(
        LoggerStorage $logger,
        VeriCodeStorage $veriCodeStorage,
        ?VeriCodeEmailSender $veriCodeEmailSender,
        ?VeriCodePhoneSender $veriCodeSMSSender,
        ?VeriCodePhoneSender $veriCodeCallSender,
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

    public function getVeriCodeSMSSender() : ?VeriCodePhoneSender{
        return $this->_veriCodeSMSSender;
    }

    public function getVeriCodeCallSender() : ?VeriCodePhoneSender{
        return $this->_veriCodeCallSender;
    }
    public function getPhoneSender(int &$methodReceiver, bool $preferSMS = true) : ?VeriCodePhoneSender{
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
    public function createAndSendVerificationEmail(string $emailAddr, UserEntity $user, int $currentTime, int $vericodeAvailableDuration, ?string $remoteAddr) : ?PDKException{
        $verifyEmailEntity = new VeriCodeEntity(
            VeriCodeIDs::VERICODE_VERIFY_EMAIL(),
            $currentTime,
            $currentTime + $vericodeAvailableDuration,
            $user->getUID(),
            APPSystemConstants::INTERACTIVEPDK_APPUID,
            null,
            $remoteAddr
        );
        while($this->getVeriCodeStorage()->checkVeriCodeExist($verifyEmailEntity->getVeriCodeString())){
            $verifyEmailEntity = $verifyEmailEntity->withVeriCodeStringReroll();
        }
        try{
            $this->getVeriCodeEmailSender()->sendVeriCode($verifyEmailEntity,$user,$user->getEmail());
        }catch(PDKSenderServiceError $e){
            return $e;
        }
        $verifyEmailEntity = $verifyEmailEntity->withSentMethod(SentMethod::EMAIL);
        try{
            $this->getVeriCodeStorage()->addVeriCodeEntity($verifyEmailEntity,false);
        }catch(PDKStorageEngineError $e){
            return $e;
        }
        return null;
    }
    public function createAndSendVerificationPhone(PhoneNumber $phoneNum, UserEntity $user, int $currentTime, int $vericodeAvailableDuration, int &$methodReceiver, ?string $remoteAddr, bool $preferSMS = true) : ?PDKException{
        $verifyPhoneEntity = new VeriCodeEntity(
            VeriCodeIDs::VERICODE_VERIFY_PHONE(),
            $currentTime,
            $currentTime + $vericodeAvailableDuration,
            $user->getUID(),
            APPSystemConstants::INTERACTIVEPDK_APPUID,
            null,
            $remoteAddr
        );
        while($this->getVeriCodeStorage()->checkVeriCodeExist($verifyPhoneEntity->getVeriCodeString())){
            $verifyPhoneEntity = $verifyPhoneEntity->withVeriCodeStringReroll();
        }
        try{
            $this->getPhoneSender($methodReceiver,$preferSMS)->sendVeriCode($verifyPhoneEntity,$user,$user->getPhoneNumber());
        }catch(PDKSenderServiceError $e){
            return $e;
        }
        $verifyPhoneEntity = $verifyPhoneEntity->withSentMethod($methodReceiver);
        try{
            $this->getVeriCodeStorage()->addVeriCodeEntity($verifyPhoneEntity,false);
        }catch(PDKStorageEngineError $e){
            return $e;
        }
        return null;
    }
}