<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket\TicketRecord;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;

abstract class OAuthTicketRecordStorage{
    public abstract function addOAuthTicketRecord(OAuthTicketRecordEntity $entity) : void;
    public abstract function checkOAuthTicketRecordExist(string $ticket_id) : bool;
    public abstract function getOAuthTicketRecord(string $ticket_id) : ?OAuthTicketRecordEntity;
    public abstract function updateOAuthTicketRecord(OAuthTicketRecordEntity $entity) : void;
    public abstract function searchOAuthTicketRecordEntity(
        int $createTimeStart = -1,
        int $createTimeEnd = -1, 
        int $lastUpdateStart = -1, 
        int $lastUpdateEnd = -1, 
        int $realatedUID = UserSystemConstants::NO_USER_RELATED_UID,
        ?string $relatedMaskID = null,
        ?string $relatedClientID = null,
        int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, 
        ?string $relatedAccessToken = null,
        int $dataOffset = 0, 
        int $dataCountLimit = -1
    ) : MultipleResult;
    public abstract function getOAuthStorageRecordEntityCount(
        int $createTimeStart = -1,
        int $createTimeEnd = -1, 
        int $lastUpdateStart = -1, 
        int $lastUpdateEnd = -1, 
        int $realatedUID = UserSystemConstants::NO_USER_RELATED_UID,
        ?string $relatedMaskID = null,
        ?string $relatedClientID = null,
        int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, 
        ?string $relatedAccessToken = null
    ) : int;
    public abstract function clearAuthCode(
        int $createTimeStart = -1,
        int $createTimeEnd = -1, 
        int $lastUpdateStart = -1, 
        int $lastUpdateEnd = -1, 
        int $realatedUID = UserSystemConstants::NO_USER_RELATED_UID,
        ?string $relatedMaskID = null,
        ?string $relatedClientID = null,
        int $relatedAPPUID = APPSystemConstants::NO_APP_RELATED_APPUID, 
        ?string $relatedAccessToken = null,
        int $dataOffset = 0, 
        int $dataCountLimit = -1
    ) : void;
}