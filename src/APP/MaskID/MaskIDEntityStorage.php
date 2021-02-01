<?php
namespace InteractivePlus\PDK2021Core\APP\MaskID;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;

abstract class MaskIDEntityStorage{
    protected abstract function __addMaskIDEntity(MaskIDEntity $entity) : void;
    public abstract function checkMaskIDExist(string $maskID) : int;
    public abstract function getMaskIDEntityByMaskID(string $maskID) : ?MaskIDEntity;
    protected abstract function __updateMaskIDEntity(MaskIDEntity $entity) : void;
    public abstract function searchMaskIDEntity(?string $maskID = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $ownerUID = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID, int $dataOffset = 0, int $dataCountLimit = -1) : MultipleResult;
    public abstract function getMaskIDEntityCount(?string $maskID = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $ownerUID = UserSystemConstants::NO_USER_RELATED_UID, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID) : int;
    public function updateMaskIDEntity(MaskIDEntity $entity) : void{
        $checkRst = $this->checkMaskIDExist($entity->getMaskID());
        if($checkRst !== $entity->uid){
            throw new PDKInnerArgumentError('maskID');
        }
        $this->__updateMaskIDEntity($entity);
    }
    public function addAPPEntity(MaskIDEntity $entity, bool $withMaskIDReroll) : ?MaskIDEntity{
        $returningObj = $entity;
        while($this->checkMaskIDExist($returningObj->getMaskID()) !== -1){
            if(!$withMaskIDReroll){
                return null;
            }
            $returningObj = $returningObj->withMaskIDReroll();
        }
        $this->__addMaskIDEntity($returningObj);
        return $returningObj;
    }
}