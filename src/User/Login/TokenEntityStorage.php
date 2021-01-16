<?php
namespace InteractivePlus\PDK2021\User\Login;

use InteractivePlus\PDK2021\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021\Base\DataOperations\MultipleResult;

abstract class TokenEntityStorage{
    protected abstract function __addTokenEntity(TokenEntity $Token) : void;
    protected abstract function __checkTokenExist(string $TokenString) : bool;
    protected abstract function __checkRefreshTokenExist(string $RefreshTokenString) : bool;
    public abstract function getTokenEntity(string $TokenString) : ?TokenEntity;
    public abstract function getTokenEntitybyRefreshToken(string $refreshToken) : ?TokenEntity;

    /**
     * Updates an Token entity
     * @param TokenEntity $Token
     * @throws InteractivePlus\PDK2021Base\Exception\ExceptionTypes\PDKStorageEngineError
     * @return bool if the update was successful
     */
    public abstract function updateTokenEntity(TokenEntity $Token) : bool;
    
    public abstract function setTokenEntityInvalid(string $TokenString) : void;

    /**
     * search Tokens with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $lastRenewTimeMin Min for the Last Renew Time, <= 0 = unlimited
     * @param int $lastRenewTimeMax Max for the Last Renew Time, <= 0 = unlimited
     * @param int $refreshExpireMin Min for the Refresh Token Expire Time, <= 0 = unlimited
     * @param int $refreshExpireMax Max for the Refresh Token Expire Time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     * @return InteractivePlus\PDK2021Base\DataOperations\MultipleResult result object
     */
    public abstract function searchToken(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $lastRenewTimeMin = 0, int $lastRenewTimeMax = 0, int $refreshExpireMin = 0, int $refreshExpireMax = 0, int $uid = UserSystemConstants::NO_USER_RELATED_UID) : MultipleResult;

    /**
     * clear Tokens with search constraints
     * @param int $issueTimeMin Min for the issue time, <= 0 = unlimited
     * @param int $issueTimeMax Max for the issue time, <= 0 = unlimited
     * @param int $expireTimeMin Min for the expire time, <= 0 = unlimited
     * @param int $expireTimeMax Max for the expire time, <= 0 = unlimited
     * @param int $lastRenewTimeMin Min for the Last Renew Time, <= 0 = unlimited
     * @param int $lastRenewTimeMax Max for the Last Renew Time, <= 0 = unlimited
     * @param int $refreshExpireMin Min for the Refresh Token Expire Time, <= 0 = unlimited
     * @param int $refreshExpireMax Max for the Refresh Token Expire Time, <= 0 = unlimited
     * @param int $uid limit search to a specific user, if no limit, set this to UserSystemConstants::NO_USER_RELATED_UID
     */
    public abstract function clearToken(int $issueTimeMin = 0, int $issueTimeMax = 0, int $expireTimeMin = 0, int $expireTimeMax =0, int $lastRenewTimeMin = 0, int $lastRenewTimeMax = 0, int $refreshExpireMin = 0, int $refreshExpireMax = 0, int $uid = UserSystemConstants::NO_USER_RELATED_UID) : void;
    
    public abstract function getTokenCount() : int;

    /**
     * Adds a TokenEntity to the storage
     * @param TokenEntity $Token the entity to store
     * @param bool $reRollTokenStrIfExist if there is a conflict with existing Token string in the storage, shall we reroll Token string or give up storing it?
     * @return ?TokenEntity the saved entity, null if not saved
     */
    public function addTokenEntity(TokenEntity $Token, bool $reRollTokenStrIfExist = true, bool $reRollRefreshTokenStrIfExist = true) : ?TokenEntity{
        if($this->__checkTokenExist($Token->getTokenStr())){
            if($reRollTokenStrIfExist){
                return $this->addTokenEntity($Token->withTokenReroll(),true,$reRollRefreshTokenStrIfExist);
            }else{
                return null;
            }
        }else if($this->__checkRefreshTokenExist($Token->getRefreshTokenStr())){
            if($reRollRefreshTokenStrIfExist){
                return $this->addTokenEntity($Token->withRefreshTokenReroll(),$reRollTokenStrIfExist,true);
            }else{
                return null;
            }
        }else{
            $this->__addTokenEntity($Token);
            return $Token;
        }
    }
}