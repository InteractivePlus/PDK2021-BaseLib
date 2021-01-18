<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;

abstract class VeriCodeStorage{
    protected abstract function __addVeriCodeEntity(VeriCodeEntity $veriCode) : void;
    public abstract function checkVeriCodeExist(string $veriCodeString) : bool;
    public abstract function getVeriCodeEntity(string $veriCodeString) : ?VeriCodeEntity;
    
    /**
     * Updates an vericode entity
     * @param VeriCodeEntity $veriCode
     * @throws InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError
     * @return bool if the update was successful
     */
    public abstract function updateVeriCodeEntity(VeriCodeEntity $veriCode) : bool;
    
    public abstract function useVeriCodeEntity(string $veriCodeString) : void;

    /**
     * search Verification Codes with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     * @param int $appuid limit search to a specific app, if no limit, set this to APPSystemConstants::NO_APP_RELATED_APPUID
     * @param int $veriCodeID Verification Code ID, set to 0 if no specific Code required
     * @return InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult result object
     */
    public abstract function searchVeriCode(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $uid = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID, int $veriCodeID = 0) : MultipleResult;

    public abstract function searchPhoneVeriCode(int $expireTimeMin = 0, int $expireTimeMax = 0, int $uid = UserSystemConstants::NO_USER_RELATED_UID,int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID, string $partialVericodeStr, int $veriCodeID = 0) : MultipleResult;

    /**
     * clear Verification Codes with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     * @param int $appuid limit search to a specific app, if no limit, set this to APPSystemConstants::NO_APP_RELATED_APPUID
     * @param int $veriCodeID Verification Code ID, set to 0 if no specific Code required
     */
    public abstract function clearVeriCode(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $uid = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID, int $veriCodeID = 0) : void;
    
    public abstract function getVeriCodeCount() : int;

    /**
     * Adds a VeriCodeEntity to the storage
     * @param VeriCodeEntity $veriCode the entity to store
     * @param bool $reRollVeriCodeStrIfExist if there is a conflict with existing VeriCode string in the storage, shall we reroll VeriCode string or give up storing it?
     * @return ?VeriCodeEntity the saved entity, null if not saved
     */
    public function addVeriCodeEntity(VeriCodeEntity $veriCode, bool $reRollVeriCodeStrIfExist) : ?VeriCodeEntity{
        if($this->checkVeriCodeExist($veriCode->getVeriCodeString())){
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