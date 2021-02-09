<?php
namespace InteractivePlus\PDK2021Core\APP\APPToken;

use InteractivePlus\PDK2021Core\APP\APPInfo\APPEntity;
use InteractivePlus\PDK2021Core\APP\Format\APPFormat;
use InteractivePlus\PDK2021Core\APP\Format\MaskIDFormat;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;

class APPTokenEntity{
    private string $_access_token;
    private string $_refresh_token;
    public int $issueTime;
    public int $expireTime;
    public int $lastRefreshTime;
    public int $refreshExpireTime;
    private string $_maskID;
    public int $appuid;
    private string $_client_id;
    private int $_obtainedMethod;
    public array $scopes;
    public bool $valid;

    public function __construct(
        string $accessToken,
        string $refreshToken,
        int $issueTime,
        int $expireTime,
        int $lastRefreshTime,
        int $refreshExpireTime,
        string $maskID,
        int $appuid,
        string $clientID,
        int $obtainedMethod,
        array $scopes,
        bool $valid = true
    )
    {
        if(!APPFormat::isValidAPPAccessToken($accessToken)){
            throw new PDKInnerArgumentError('access_token');
        }
        $this->_access_token = APPFormat::formatAPPAccessToken($accessToken);
        $this->setRefreshToken($refreshToken);
        $this->issueTime = $issueTime;
        $this->expireTime = $expireTime;
        $this->lastRefreshTime = $lastRefreshTime;
        $this->refreshExpireTime = $refreshExpireTime;
        $this->setMaskID($maskID);
        $this->appuid = $appuid;
        $this->setClientID($clientID);
        $this->setObtainedMethod($obtainedMethod);
        $this->scopes = $scopes;
        $this->valid = $valid;
    }

    public function getAccessToken() : string{
        return $this->_access_token;
    }
    public function withAccessToken(string $access_token) : APPTokenEntity{
        if(!APPFormat::isValidAPPAccessToken($access_token)){
            throw new PDKInnerArgumentError('access_token');
        }
        $newEntity = clone $this;
        $newEntity->_access_token = APPFormat::formatAPPAccessToken($access_token);
        return $newEntity;
    }
    public function withAccessTokenReroll() : APPTokenEntity{
        return $this->withAccessToken(APPFormat::generateAPPAccessToken());
    }
    public function getRefreshToken() : string{
        return $this->_refresh_token;
    }
    public function setRefreshToken(string $refresh_token) : void{
        if(!APPFormat::isValidAPPRefreshToken($refresh_token)){
            throw new PDKInnerArgumentError('refresh_token');
        }
        $this->_refresh_token = APPFormat::formatAPPRefreshToken($refresh_token);
    }
    public function doRefreshTokenReroll() : void{
        $this->_refresh_token = APPFormat::generateAPPRefreshToken();
    }
    public function getMaskID() : string{
        return $this->_maskID;
    }
    public function setMaskID(string $maskID) : void{
        if(!MaskIDFormat::isValidMaskID($maskID)){
            throw new PDKInnerArgumentError('maskID');
        }
        $this->_maskID = $maskID;
    }
    public function getClientID() : string{
        return $this->_client_id;
    }
    public function setClientID(string $clientID) : void{
        if(!APPFormat::isValidAPPID($clientID)){
            throw new PDKInnerArgumentError('client_id');
        }
        $this->_client_id = APPFormat::formatAPPID($clientID);
    }
    public function setClient(APPEntity $app) : void{
        $this->appuid = $app->getAPPUID();
        $this->_client_id = $app->getClientID();
    }
    public function getObtainedMethod() : int{
        return $this->_obtainedMethod;
    }
    public function setObtainedMethod(int $obtainedMethod) : void{
        $this->_obtainedMethod = APPTokenObtainedMethod::fixObtainedMethod($obtainedMethod);
    }
    public function hasScope(string $scope) : bool{
        $scope = strtolower(trim($scope));
        foreach($this->scopes as $i){
            if(strtolower(trim($i)) === $scope){
                return true;
            }
        }
        return false;
    }
}