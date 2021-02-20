<?php
namespace InteractivePlus\PDK2021Core\APP\APPInfo;

use InteractivePlus\PDK2021Core\APP\APPSystemFormatSetting;
use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError;

abstract class APPEntityStorage{
    private APPSystemFormatSetting $_formatSetting;

    public function __construct(APPSystemFormatSetting $formatSetting){
        $this->_formatSetting = $formatSetting;
    }

    public function getFormatSetting() : APPSystemFormatSetting{
        return $this->_formatSetting;
    }
    protected abstract function __addAPPEntity(APPEntity $entity) : int;
    public abstract function checkAPPUIDExist(int $appuid) : bool;
    public abstract function checkClientIDExist(string $clientID) : int;
    public abstract function checkDisplayNameExist(string $displayName) : int;
    public abstract function getAPPEntityByAPPUID(int $appuid) : ?APPEntity;
    public abstract function getAPPEntityByDisplayName(string $displayName) : ?APPEntity;
    public abstract function getAPPEntityByClientID(string $clientID) : ?APPEntity;
    protected abstract function __updateAPPEntity(APPEntity $entity) : void;
    public abstract function searchAPPEntity(?string $displayName = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $ownerUID = UserSystemConstants::NO_USER_RELATED_UID, int $dataOffset = 0, int $dataCountLimit = -1) : MultipleResult;
    public abstract function getAPPEntityCount(?string $displayName = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $ownerUID = UserSystemConstants::NO_USER_RELATED_UID) : int;
    public function updateAPPEntity(APPEntity $entity) : void{
        $checkRst = $this->checkClientIDExist($entity->getClientID());
        if($checkRst !== -1 && $checkRst !== $entity->getAPPUID()){
            throw new PDKInnerArgumentError('client_id');
        }
        $displayNameRst = $this->checkDisplayNameExist($entity->getDisplayName());
        if($checkRst !== -1 && $checkRst !== $entity->getAPPUID()){
            throw new PDKInnerArgumentError('display_name');
        }
        $this->__updateAPPEntity($entity);
    }
    public function addAPPEntity(APPEntity $entity, bool $withClientIDReroll) : ?APPEntity{
        if($this->checkDisplayNameExist($entity->getDisplayName())){
            return null;
        }
        while($this->checkClientIDExist($entity->getClientID()) !== -1){
            if(!$withClientIDReroll){
                return null;
            }
            $entity->doClientIDReroll();
        }
        $allocatedAPPID = $this->__addAPPEntity($entity);
        if($allocatedAPPID === APPSystemConstants::NO_APP_RELATED_APPUID){
            throw new PDKStorageEngineError('Failed to store APP Entity into Database');
        }else{
            return $entity->withAPPUID($allocatedAPPID);
        }
    }
}