<?php
namespace InteractivePlus\PDK2021Core\APP\AuthCode;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;

abstract class AuthCodeStorage{
    protected abstract function __addAuthCodeEntity(AuthCodeEntity $entity) : void;
    public abstract function checkAuthCodeExist(string $authCode) : bool;
    public abstract function getAuthCodeEntity(string $authCode) : ?AuthCodeEntity;
    public abstract function updateAuthCodeEntity(AuthCodeEntity $entity) : void;
    public abstract function useAuthCode(string $authCode) : void;
    public abstract function searchAuthCodeEntity(?string $authCode = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $expireTimeStart = -1, int $expireTimeEnd = -1, ?string $relatedMaskID = null, int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, int $dataOffset = 0, int $dataCountLimit = -1) : MultipleResult;
    public abstract function getAPPEntityCount(?string $authCode = null, int $createTimeStart = -1, int $createTimeEnd = -1, int $expireTimeStart = -1, int $expireTimeEnd = -1, ?string $relatedMaskID = null, int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID) : int;
    public function addAuthCodeEntity(AuthCodeEntity $entity, bool $withAuthCodeReroll = true) : ?AuthCodeEntity{
        $returnEntity = $entity;
        while($this->checkAuthCodeExist($returnEntity->getAuthCodeStr())){
            if(!$withAuthCodeReroll){
                return null;
            }
            $returnEntity = $returnEntity->withAuthCodeReroll();
        }
        $this->__addAuthCodeEntity($returnEntity);
        return $returnEntity;
    }
}