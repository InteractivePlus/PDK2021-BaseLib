<?php
namespace InteractivePlus\PDK2021Core\User\UserInfo;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Formats\IPFormat;
use InteractivePlus\PDK2021Core\User\Login\LoginFailedReasons;
use InteractivePlus\PDK2021Core\User\Formats\UserFormat;
use InteractivePlus\PDK2021Core\User\Formats\UserPhoneUtil;
use InteractivePlus\PDK2021Core\User\Setting\CombinedSetting;
use InteractivePlus\PDK2021Core\User\Setting\SettingBoolean;
use InteractivePlus\PDK2021Core\User\Setting\UserSetting;
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
    private ?UserSystemFormatSetting $_formatSetting = null;
    private ?UserSetting $_setting = null;
    private ?UserSetting $_userSystemDefaultSetting = null;

    /**
     * This function should never ever be called outside of a UserEntityStorage class as it has absolutely no check on its parameters
     */
    private function __construct()
    {
        
    }
    
    public function getFormatClass() : ?UserSystemFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatClass(?UserSystemFormatSetting $class = null) : void{
        $this->_formatSetting = $class;
    }
    public function getSettings() : UserSetting{
        return $this->_setting;
    }
    public function setSettings(UserSetting $setting){
        $this->_setting = $setting;
    }
    public function getDefaultSettings() : UserSetting{
        return $this->_userSystemDefaultSetting;
    }
    public function setDefaultSettings(UserSetting $setting){
        $this->_userSystemDefaultSetting = $setting;
    }
    public function getCombinedSettings() : UserSetting{
        return new CombinedSetting($this->_setting,$this->_userSystemDefaultSetting);
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
            return;
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
            return;
        }
        if($this->_formatSetting !== null){
            if(!$this->_formatSetting->checkSignature($signature)){
                throw new PDKInnerArgumentError('signature');
            }
        }
        $this->_signature = $signature;
    }
    public function getPasswordHash() : string{
        return $this->_passwordHash;
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
    public function setPasswordHash(string $hash) : void{
        if(UserFormat::isPasswordHashValid($hash)){
            $this->_passwordHash = UserFormat::formatPasswordHash($hash);
        }
    }
    public function getEmail() : ?string{
        return $this->_email;
    }
    public function setEmail(?string $email) : void{
        if(empty($email)){
            $this->_email = null;
            return;
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
            return;
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

    public static function fromDatabase(
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
        UserSystemFormatSetting $formatSetting,
        UserSetting $defaultSetting,
        UserSetting $userSetting
    ) : UserEntity{
        $entity = new UserEntity();
        $entity->_uid = $uid;
        $entity->_formatSetting = $formatSetting;
        $entity->_username = $username;
        $entity->_nickname = empty($nickname) ? null : $nickname;
        $entity->_signature = empty($signature) ? null : $signature;
        $entity->_passwordHash = $passwordHash;
        $entity->_email = empty($email) ? null : $email;
        $entity->_phone = $phone;
        $entity->_emailVerified = $emailVerified;
        $entity->_phoneVerified = $phoneVerified;
        $entity->_accountCreateTime = $accountCreateTime;
        $entity->_accountCreateIP = $accountCreateIP;
        $entity->_accountFrozen = $accountFrozen;
        $entity->_userSystemDefaultSetting = $defaultSetting;
        $entity->_setting = $userSetting;
        
        return $entity;
    }
    public static function create(
        string $username,
        ?string $nickname = null,
        ?string $signature = null,
        string $password,
        ?string $email = null,
        ?PhoneNumber $phone = null,
        bool $emailVerified,
        bool $phoneVerified,
        int $accountCreateTime,
        string $accountCreateIP,
        bool $accountFrozen,
        UserSystemFormatSetting $formatSetting,
        UserSetting $defaultSetting
    ) : UserEntity{
        $entity = new UserEntity();
        $entity->_uid = -1;
        $entity->_formatSetting = $formatSetting;
        $entity->setUsername($username);
        $entity->setNickName($nickname);
        $entity->setSignature($signature);
        $entity->setPassword($password);
        $entity->setEmail($email);
        $entity->setPhoneNumber($phone);
        $entity->_emailVerified = $emailVerified;
        $entity->_phoneVerified = $phoneVerified;
        $entity->_accountCreateTime = $accountCreateTime;
        $entity->setAccountCreateIP($accountCreateIP);
        $entity->_accountFrozen = $accountFrozen;
        $entity->_userSystemDefaultSetting = $defaultSetting;
        $entity->_setting = new UserSetting(
            SettingBoolean::INHERIT,
            SettingBoolean::INHERIT,
            SettingBoolean::INHERIT,
            SettingBoolean::INHERIT,
            SettingBoolean::INHERIT,
            SettingBoolean::INHERIT
        );
        return $entity;
    }
}