<?php
namespace InteractivePlus\PDK2021Core\EXT_Storage\StorageRecord;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;

abstract class OAuthStorageRecordStorage{
    public abstract function addOAuthStorageRecord(OAuthStorageRecordEntity $entity) : void;
    public abstract function checkOAuthStorageRecordExist(string $mask_id, string $client_id) : bool;
    public abstract function checkOAuthStorageRecordExistByAPPUID(string $mask_id, int $appuid) : bool;
    public abstract function getOAuthStorageRecord(string $mask_id, string $client_id) : ?OAuthStorageRecordEntity;
    public abstract function getOAuthStorageRecordByAPPUID(string $mask_id, int $appuid) : ?OAuthStorageRecordEntity;
    public abstract function updateOAuthStorageRecord(OAuthStorageRecordEntity $entity) : void;
    public abstract function searchOAuthStorageRecordEntity(int $createTimeStart = -1, int $createTimeEnd = -1, int $lastUpdateStart = -1, int $lastUpdateEnd = -1, ?string $relatedMaskID = null, ?string $relatedClientID = null, int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, int $dataOffset = 0, int $dataCountLimit = -1) : MultipleResult;
    public abstract function getOAuthStorageRecordEntityCount(int $createTimeStart = -1, int $createTimeEnd = -1, int $lastUpdateStart = -1, int $lastUpdateEnd = -1, ?string $relatedMaskID = null, ?string $relatedClientID = null, int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID) : int;
    public abstract function clearAuthCode(int $createTimeStart = -1, int $createTimeEnd = -1, int $lastUpdateStart = -1, int $lastUpdateEnd = -1, ?string $relatedMaskID = null, ?string $relatedClientID = null, int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, int $dataOffset = 0, int $dataCountLimit = -1) : void;
}