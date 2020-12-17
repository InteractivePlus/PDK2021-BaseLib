<?php
namespace InteractivePlus\PDK2021\User\UserInfo;

use InteractivePlus\PDK2021\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021\Base\Exception\ExceptionTypes\PDKRequestParamFormatError;
use InteractivePlus\PDK2021\User\Login\LoginFailedReasons;
use InteractivePlus\PDK2021\User\UserFormat;
use InteractivePlus\PDK2021\User\UserSystemFormatSetting;
use libphonenumber\PhoneNumber;

class UserEntity{
    private int $_uid;
    private string $_username;
    private ?string $_nickname;
    private ?string $_signature;
    private string $_passwordHash;
    private ?string $_email;
    private ?PhoneNumber $_phone;
    private bool $_emailVerified = false;
    private bool $_phoneVerified = false;
    private int $_accountCreateTime = 0;
    private string $_accountCreateIP;
    private bool $_accountFrozen = false;
    private ?UserSystemFormatSetting $_formatSetting = null;
    public function __construct(
        int $uid,
        string $username,
        ?string $nickname = null,
        ?string $signature = null,
        string $passwordHash,
        ?string $email = null,
        ?PhoneNumber $phone = null,
        bool $emailVerified,
        bool $phoneVerified,
        int $accountCreateTime,
        string $accountCreateIP,
        bool $accountFrozen
    ){
        $this->_uid = $uid;
        $this->_username = $username;
        $this->_nickname = empty($nickname) ? null : $signature;
        $this->_signature = empty($signature) ? null : $signature;
        $this->_passwordHash = $passwordHash;
        $this->_email = empty($email) ? null : $email;
        $this->_phone = $phone;
        $this->_emailVerified = $emailVerified;
        $this->_phoneVerified = $phoneVerified;
        $this->_accountCreateTime = $accountCreateTime;
        $this->_accountCreateIP = $accountCreateIP;
        $this->_accountFrozen = $accountFrozen;
    }
    public function getFormatClass() : UserSystemFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatClass(UserSystemFormatSetting $class) : void{
        $this->_formatSetting = $class;
    }
    public function getUID() : int{
        return $this->_uid;
    }
    public function getUsername() : string{
        return $this->_username;
    }
    public function setUsername(string $username) : void{
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkUserName($username)){
                throw new PDKRequestParamFormatError('username');
            }
        }
        $this->_username = $username;
    }
    public function checkIfCanLogin(int &$reasonReceiver) : bool{
        if(!$this->_emailVerified && !$this->_phoneVerified){
            if($this->_email !== null && $this->_phone !== null){
                $reasonReceiver = LoginFailedReasons::EITHER_NOT_VERIFIED;
            }else if($this->_email != null){
                $reasonReceiver = LoginFailedReasons::EMAIL_NOT_VERIFIED;
            }else{
                $reasonReceiver = LoginFailedReasons::PHONE_NOT_VERIFIED;
            }
            return false;
        }else if($this->_accountFrozen){
            $reasonReceiver = LoginFailedReasons::ACCOUNT_FROZEN;
            return false;
        }
        return true;
    }
    public function getNickName() : ?string{
        return $this->_nickname;
    }
    public function setNickName(?string $nickname) : void{
        if(empty($nickname)){
            $this->_nickname = null;
        }
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkNickName($nickname)){
                throw new PDKRequestParamFormatError('nickname');
            }
        }
        $this->_nickname = $nickname;
    }
    public function getSignature() : ?string{
        return $this->_signature;
    }
    public function setSignature(?string $signature) : void{
        if(empty($signature)){
            $this->_signature = null;
        }
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkSignature($signature)){
                throw new PDKRequestParamFormatError('signature');
            }
        }
        $this->_signature = $signature;
    }
    public function checkPassword(string $passwordToCheckIfMatch) : bool{
        $passwordHashSalt = null;
        if($this->_formatSetting === null){
            $passwordHashSalt = $this->_formatSetting->getHashEncryptionSalt();
        }
        return UserFormat::checkPasswordMatch($passwordToCheckIfMatch,$this->_passwordHash,$passwordHashSalt);
    }
    public function setPassword(string $password) : void{
        $passwordHashSalt = null;
        if($this->_formatSetting === null){
            $passwordHashSalt = $this->_formatSetting->getHashEncryptionSalt();
        }else{
            if(!$this->_formatSetting->checkPassword($password)){
                throw new 
            }
        }
        
    }
}