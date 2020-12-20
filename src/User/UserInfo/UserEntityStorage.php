<?php
namespace InteractivePlus\PDK2021\User\UserInfo;

use InteractivePlus\PDK2021\Base\Exception\ExceptionTypes\PDKItemAlreadyExistError;
use libphonenumber\PhoneNumber;

abstract class UserEntityStorage{
    /**
     * @return int -1 if failed, UID if added.
     */
    protected abstract function __addUserEntity(UserEntity $userEntity) : int;

    /**
     * @param UserEntity $user the UID, Email, and PhoneNumber are guarenteed to be unique as they are checked in the public method
     */
    protected abstract function __updateUserEntity(UserEntity $user) : bool;

    /**
     * @return int -1 if non-existant, UID if exist
     */
    protected abstract function __checkUsernameExist(string $username) : int;
    /**
     * @return int -1 if non-existant, UID if exist
     */
    protected abstract function __checkEmailExist(string $email) : int;

    /**
     * @return int -1 if non-existant, UID if exist
     */
    protected abstract function __checkPhoneNumExist(PhoneNumber $phoneNumber) : int;

    public abstract function getUserEntityByUsername(string $username) : ?UserEntity;
    public abstract function getUserEntityByEmail(string $email) : ?UserEntity;
    public abstract function getUserEntityByPhoneNum(PhoneNumber $phoneNumber) : ?UserEntity;
    public abstract function getUserEntityByUID(int $uid) : ?UserEntity;

    
    /**
     * Updates an vericode entity
     * @param VeriCodeEntity $veriCode
     * @throws InteractivePlus\PDK2021Base\Exception\ExceptionTypes\PDKStorageEngineError
     * @throws InteractivePlus\PDK2021Base\Exception\ExceptionTypes\PDKItemAlreadyExistError
     * @return bool if the update was successful
     */
    public function updateUserEntity(UserEntity $user) : bool{
        if ($this->__checkUsernameExist($user->getUsername()) != $user->getUID()){
            throw new PDKItemAlreadyExistError('username');
        }
        if ($user->getEmail() !== null && $this->__checkEmailExist($user->getEmail()) != $user->getUID()){
            throw new PDKItemAlreadyExistError('email');
        }
        if ($user->getPhoneNumber() !== null && $this->__checkPhoneNumExist($user->getPhoneNumber()) != $user->getUID()){
            throw new PDKItemAlreadyExistError('phone');
        }
        return $this->__updateUserEntity($user);
    }

    //TODO: FInish this file.

    /**
     * search Verification Codes with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     * @param int $appuid limit search to a specific app, if no limit, set this to APPSystemConstants::NO_APP_RELATED_APPUID
     * @return InteractivePlus\PDK2021Base\DataOperations\MultipleResult result object
     */
    public abstract function searchVeriCode(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $uid = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID) : MultipleResult;

    /**
     * clear Verification Codes with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     * @param int $appuid limit search to a specific app, if no limit, set this to APPSystemConstants::NO_APP_RELATED_APPUID
     */
    public abstract function clearVeriCode(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $uid = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID) : void;
    
    /**
     * Adds a VeriCodeEntity to the storage
     * @param VeriCodeEntity $veriCode the entity to store
     * @param bool $reRollVeriCodeStrIfExist if there is a conflict with existing VeriCode string in the storage, shall we reroll VeriCode string or give up storing it?
     * @return ?VeriCodeEntity the saved entity, null if not saved
     */
    public function addVeriCodeEntity(VeriCodeEntity $veriCode, bool $reRollVeriCodeStrIfExist) : ?VeriCodeEntity{
        if($this->__checkVeriCodeExist($veriCode->getVeriCodeString())){
            if($reRollVeriCodeStrIfExist){
                return $this->addVeriCodeEntity($veriCode->withVeriCodeStringReroll(),true);
            }else{
                return null;
            }
        }else{
            $this->__addVeriCodeEntity($veriCode);
            return $veriCode;
        }
    }
}