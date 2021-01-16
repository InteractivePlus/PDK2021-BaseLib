<?php
namespace InteractivePlus\PDK2021Core\User\UserInfo;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Formats\IPFormat;
use InteractivePlus\PDK2021Core\User\Login\LoginFailedReasons;
use InteractivePlus\PDK2021Core\User\Formats\UserFormat;
use InteractivePlus\PDK2021Core\User\Formats\UserPhoneUtil;
use InteractivePlus\PDK2021Core\User\UserSystemFormatSetting;
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
    private UserSystemFormatSetting $_formatSetting = null;
    /**
     * This function should never ever be called outside of a UserEntityStorage class as it has absolutely no check on its parameters
     */
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
        bool $accountFrozen,
        UserSystemFormatSetting $formatSetting
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
        $this->_formatSetting = $formatSetting;
    }
    public function getFormatClass() : UserSystemFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatClass(UserSystemFormatSetting $class) : void{
        $this->_formatSetting = $class;
    }
    /**
     * If this is InteractivePlus\PDK2021Core\Base\Constant\UserSystemConstants::NO_USER_RELATED_UID, it means that this user requires to be added into the storage and to be assigned with an UID
     * @see InteractivePlus\PDK2021Core\Base\Constant\UserSystemConstants
     */
    public function getUID() : int{
        return $this->_uid;
    }
    public function withUID(int $uid) : UserEntity{
        $newUserEntity = clone $this;
        $newUserEntity->_uid = $uid;
        return $newUserEntity;
    }
    public function getUsername() : string{
        return $this->_username;
    }
    public function setUsername(string $username) : void{
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkUserName($username)){
                throw new PDKInnerArgumentError('username');
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
                throw new PDKInnerArgumentError('nickname');
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
                throw new PDKInnerArgumentError('signature');
            }
        }
        $this->_signature = $signature;
    }
    public function checkPassword(string $passwordToCheckIfMatch) : bool{
        $passwordHashSalt = null;
        if($this->_formatSetting !== null){
            $passwordHashSalt = $this->_formatSetting->getHashEncryptionSalt();
        }
        return UserFormat::checkPasswordMatch($passwordToCheckIfMatch,$this->_passwordHash,$passwordHashSalt);
    }
    public function setPassword(string $password) : void{
        $passwordHashSalt = null;
        if($this->_formatSetting !== null){
            $passwordHashSalt = $this->_formatSetting->getHashEncryptionSalt();
            if(!$this->_formatSetting->checkPassword($password)){
                throw new PDKInnerArgumentError('password');
            }
        }
        $encryptedPassword = UserFormat::encryptPassword($password,$passwordHashSalt);
        $this->_passwordHash = $encryptedPassword;
    }
    public function getEmail() : ?string{
        return $this->_email;
    }
    public function setEmail(?string $email) : void{
        if(empty($email)){
            $this->_email = null;
        }
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkEmailAddr($email)){
                throw new PDKInnerArgumentError('email');
            }
        }
        $this->_email = $email;
    }

    public function getPhoneNumber() : ?PhoneNumber{
        return $this->_phone;
    }

    /**
     * @throws PDKInnerArgumentError
     */
    public function setPhoneNumber(?PhoneNumber $phone) : void{
        if($phone === null){
            $this->_phone = null;
        }
        if(!UserPhoneUtil::verifyPhoneNumberObj($phone)){
            throw new PDKInnerArgumentError('phone','Phone number is not a valid number');
        }
        $this->_phone = $phone;
    }

    public function isEmailVerified() : bool{
        return $this->_emailVerified;
    }

    public function setEmailVerified(bool $verified) : void{
        $this->_emailVerified = $verified;
    }

    public function isPhoneVerified() : bool{
        return $this->_phoneVerified;
    }

    public function setPhoneVerified(bool $verified) : void{
        $this->_phoneVerified = $verified;
    }

    public function getAccountCreateTime() : int{
        return $this->_accountCreateTime;
    }

    /**
     * @throws PDKInnerArgumentError
     */
    public function setAccountCreateTime(int $time) : void{
        if($time < 0){
            throw new PDKInnerArgumentError('time','account create time must be bigger or equal to 0');
        }
        $this->_accountCreateTime = $time;
    }

    public function getAccountCreateIP() : string{
        return $this->_accountCreateIP;
    }

    /**
     * @throws PDKInnerArgumentError
     */
    public function setAccountCreateIP(string $accountIP) : void{
        if(!IPFormat::isIP($accountIP)){
            throw new PDKInnerArgumentError('accountIP');
        }
        $this->_accountCreateIP = IPFormat::formatIP($accountIP);
    }

    public function isAccountFrozen() : bool{
        return $this->_accountFrozen;
    }

    public function setAccountFrozen(bool $frozen) : void{
        $this->_accountFrozen = $frozen;
    }
}