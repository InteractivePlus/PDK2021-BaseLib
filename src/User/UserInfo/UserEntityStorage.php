<?php
namespace InteractivePlus\PDK2021Core\User\UserInfo;

use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKItemAlreadyExistError;
use InteractivePlus\PDK2021Core\User\Setting\UserSetting;
use InteractivePlus\PDK2021Core\User\UserSystemFormatSetting;
use libphonenumber\PhoneNumber;

abstract class UserEntityStorage{
    private UserSystemFormatSetting $_formatSetting;
    private UserSetting $_defaultSetting;

    public function __construct(UserSystemFormatSetting $formatSetting, UserSetting $defaultSetting){
        $this->_formatSetting = $formatSetting;
        $this->_defaultSetting = $defaultSetting;
    }

    public function getFormatSetting() : UserSystemFormatSetting{
        return $this->_formatSetting;
    }

    public function getDefaultSetting() : UserSetting{
        return $this->_defaultSetting;
    }

    /**
     * adds an user entity to the database. This method should be overwritten.
     * @return int InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants::NO_USER_RELATED_UID if failed, UID if added.
     * @see \InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants
     */
    protected abstract function __addUserEntity(UserEntity $userEntity) : int;

    /**
     * @param UserEntity $user the UID, Email, and PhoneNumber are guarenteed to be unique as they are checked in the public method
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     */
    protected abstract function __updateUserEntity(UserEntity $user) : bool;

    /**
     * @return int -1 if non-existant, UID if exist
     */
    public abstract function checkUsernameExist(string $username) : int;
    /**
     * @return int -1 if non-existant, UID if exist
     */
    public abstract function checkEmailExist(string $email) : int;

    /**
     * @return int -1 if non-existant, UID if exist
     */
    public abstract function checkPhoneNumExist(PhoneNumber $phoneNumber) : int;

    /**
     * @return int -1 if non-existant, UID if exist
     */
    public abstract function checkNicknameExist(string $nickname) : int;


    public abstract function getUserEntityByUsername(string $username) : ?UserEntity;
    public abstract function getUserEntityByEmail(string $email) : ?UserEntity;
    public abstract function getUserEntityByPhoneNum(PhoneNumber $phoneNumber) : ?UserEntity;
    public abstract function getUserEntityByUID(int $uid) : ?UserEntity;

    
    /**
     * Updates an vericode entity
     * @param UserEntity $user
     * @throws InteractivePlus\PDK2021CoreBase\Exception\ExceptionTypes\PDKStorageEngineError
     * @throws InteractivePlus\PDK2021CoreBase\Exception\ExceptionTypes\PDKItemAlreadyExistError
     * @return bool if the update was successful
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     */
    public function updateUserEntity(UserEntity $user) : bool{
        $usernameUID = $this->checkUsernameExist($user->getUsername());
        if ($usernameUID !== $user->getUID() && $usernameUID !== -1){
            throw new PDKItemAlreadyExistError('username');
        }
        if (!empty($user->getEmail())){
            $emailUID = $this->checkEmailExist($user->getEmail());
            if($emailUID !== $user->getUID() && $emailUID !== -1){
                throw new PDKItemAlreadyExistError('email');
            }
        }
        if ($user->getPhoneNumber() !== null){
            $phoneUID = $this->checkPhoneNumExist($user->getPhoneNumber());
            if($phoneUID !== $user->getUID() && $phoneUID !== -1){
                throw new PDKItemAlreadyExistError('phone');
            }
        }
        if (!empty($user->getNickName())){
            $nickNameUID = $this->checkNicknameExist($user->getNickName());
            if($nickNameUID !== $user->getUID() && $nickNameUID !== -1){
                throw new PDKItemAlreadyExistError('nickname');
            }
        }
        return $this->__updateUserEntity($user);
    }

    /**
     * search User Entity with search constraints
     * @param ?string $username the (partial) username that you want to search for, if set to null, it means there's no constraint
     * @param ?string $email the (partial) email that you want to search for, if iset to null, it means there's no constraint
     * @param ?string $number the (partial) phone number that you want to search for
     * @param int $regTimeStart start of register time limitation, if no limit, set this to -1 or 0
     * @param int $regTimeEnd end of register time limitation, if no limit, set this to -1
     * @param int $dataOffset offset of the data, 0 if you want a data from the very beginning row
     * @param int $dataCountLimit count limit of the data, -1 means no limit(fetch all database rows)
     * @return InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult result object
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     */
    public abstract function searchUserIdentity(?string $username = null, ?string $email = null, ?string $number = null,int $regTimeStart = -1, int $regTimeEnd = -1, int $dataOffset = 0, int $dataCountLimit = -1) : MultipleResult;

    /**
     * fetch count of User Entities that complies to the search options below.
     * @param ?string $username the username that you want to search for, if set to null, it means there's no constraint
     * @param ?string $email the email that you want to search for, if iset to null, it means there's no constraint
     * @param ?PhoneNumber $number the specific phone number that you want to search for
     * @param int $uid the specific uid that you want to search for, if no constraint, set it to UserSystemConstants::NO_USER_RELATED_UID
     * @param int $regTimeStart start of register time limitation, if no limit, set this to -1 or 0
     * @param int $regTimeEnd end of register time limitation, if no limit, set this to -1
     * @return int total number of results
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     */
    public abstract function getUserCount(?string $username = null, ?string $email = null, ?string $number = null, int $regTimeStart = -1, int $regTimeEnd = -1) : int;

    /**
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKItemNotFoundError
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     */
    public abstract function deleteUserEntity(UserEntity $user) : void;
    
    /**
     * Adds a UserEntity to the storage
     * @param UserEntity $user the user entity to be added
     * @return ?UserEntity null if failed, the created userentity (with uid assigned) if successful
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError
     */
    public function addUserEntity(UserEntity $user) : ?UserEntity{
        if($this->checkUsernameExist($user->getUsername()) !== -1){
            throw new PDKItemAlreadyExistError('username');
        }
        if(!empty($user->getEmail()) && $this->checkEmailExist($user->getEmail()) !== -1){
            throw new PDKItemAlreadyExistError('email');
        }
        if($user->getPhoneNumber() !== null && $this->checkPhoneNumExist($user->getPhoneNumber()) !== -1){
            throw new PDKItemAlreadyExistError('phone');
        }
        if(!empty($user->getNickName()) && $this->checkNicknameExist($user->getNickName()) !== -1){
            throw new PDKItemAlreadyExistError('nickname');
        }
        $newUID = $this->__addUserEntity($user);
        if($newUID === UserSystemConstants::NO_USER_RELATED_UID){
            return null;
        }else{
            return $user->withUID($newUID);
        }
    }
}