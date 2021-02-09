<?php
namespace InteractivePlus\PDK2021Core\APP\APPToken;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;

abstract class APPTokenEntityStorage{
    protected abstract function __addAPPTokenEntity(APPTokenEntity $Token) : void;
    public abstract function checkAccessTokenExist(string $AccessTokenString) : bool;
    public abstract function checkRefreshTokenExist(string $RefreshTokenString) : bool;
    public abstract function getAPPTokenEntity(string $accessToken) : ?APPTokenEntity;
    public abstract function getAPPTokenEntitybyRefreshToken(string $refreshToken) : ?APPTokenEntity;

    public abstract function updateAPPTokenEntity(APPTokenEntity $Token) : bool;
    
    public abstract function setAPPTokenEntityInvalid(string $TokenString) : void;

    public abstract function searchAPPToken(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $lastRenewTimeMin = 0, int $lastRenewTimeMax = 0, int $refreshExpireMin = 0, int $refreshExpireMax = 0, ?string $maskID = null, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID, int $dataOffset = 0, int $dataLimit = -1) : MultipleResult;

    public abstract function getAPPTokenCount(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $lastRenewTimeMin = 0, int $lastRenewTimeMax = 0, int $refreshExpireMin = 0, int $refreshExpireMax = 0, ?string $maskID = null, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID) : int;

    public abstract function clearAPPToken(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $lastRenewTimeMin = 0, int $lastRenewTimeMax = 0, int $refreshExpireMin = 0, int $refreshExpireMax = 0, ?string $maskID = null, int $appuid = APPSystemConstants::NO_APP_RELATED_APPUID) : void;

    public function addAPPTokenEntity(APPTokenEntity $appToken, bool $reRollAccessTokenStrIfExist = true, bool $reRollRefreshTokenStrIfExist = true) : ?APPTokenEntity{
        $returnEntity = $appToken;
        while($this->checkAccessTokenExist($returnEntity->getAccessToken())){
            if(!$reRollAccessTokenStrIfExist){
                return null;
            }else{
                $returnEntity = $returnEntity->withAccessTokenReroll();
            }
        }
        while($this->checkRefreshTokenExist($returnEntity->getRefreshToken())){
            if(!$reRollRefreshTokenStrIfExist){
                return null;
            }else{
                $returnEntity->doRefreshTokenReroll();
            }
        }
        $this->__addAPPTokenEntity($returnEntity);
        return $returnEntity;
    }
}