<?php
namespace InteractivePlus\PDK2021Core\User\Login;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Formats\IPFormat;
use InteractivePlus\PDK2021Core\User\Formats\TokenFormat;
use TheSeer\Tokenizer\Token;

class TokenEntity{
    private int $_relatedUID;
    private string $_tokenStr;
    private string $_refreshTokenStr;
    public int $issueTime;
    public int $expireTime;
    public int $refreshTokenExpireTime;
    public int $lastRenewTime;
    private ?string $_remoteAddr;
    private ?string $_deviceUA;
    public bool $valid;
    
    public function __construct(
        int $relatedUID,
        int $issueTime,
        int $expireTime,
        int $refreshTokenExpireTime,
        int $lastRenewTime,
        ?string $remoteAddr = null,
        ?string $deviceUA = null,
        ?string $tokenStrOverride = null,
        ?string $refreshTokenStrOverride = null,
        bool $valid = true
    )
    {
        if(!empty($tokenStrOverride) && !TokenFormat::isValidToken($tokenStrOverride)){
            throw new PDKInnerArgumentError('tokenStrOverride','this param is not formatted correctly');
        }
        if(!empty($refreshTokenStrOverride) && !TokenFormat::isValidToken($refreshTokenStrOverride)){
            throw new PDKInnerArgumentError('refreshTokenStrOverride','this param is not formatted correctly');
        }
        $this->_relatedUID = $relatedUID;
        $this->_tokenStr = empty($tokenStrOverride) ? TokenFormat::generateToken() : TokenFormat::formatToken($tokenStrOverride);
        $this->_refreshTokenStr = empty($refreshTokenStrOverride) ? TokenFormat::generateToken() : TokenFormat::formatToken($refreshTokenStrOverride);
        $this->issueTime = $issueTime;
        $this->expireTime = $expireTime;
        $this->refreshTokenExpireTime = $refreshTokenExpireTime;
        $this->lastRenewTime = $lastRenewTime;
        $this->valid = $valid;
        if(!empty($remoteAddr)){
            if(IPFormat::isIP($remoteAddr)){
                $this->_remoteAddr = IPFormat::formatIP($remoteAddr);
            }else{
                throw new PDKInnerArgumentError('remoteAddr','This IP Address is not formatted correctly');
            }
        }else{
            $this->_remoteAddr = null;
        }
        $this->_deviceUA = empty($deviceUA) ? null : $deviceUA;
    }
    public function getRelatedUID() : int{
        return $this->_relatedUID;
    }
    public function withRelatedUID(int $relatedUID) : TokenEntity{
        $newEntity = clone $this;
        $newEntity->_relatedUID = $relatedUID;
        return $newEntity;
    }
    public function getTokenStr() : string{
        return $this->_tokenStr;
    }
    public function withTokenStr(string $tokenStr) : TokenEntity{
        if(!TokenFormat::isValidToken($tokenStr)){
            throw new PDKInnerArgumentError('tokenStr','this param is not formatted correctly');
        }
        $newEntity = clone $this;
        $newEntity->_tokenStr = TokenFormat::formatToken($tokenStr);
        return $newEntity;
    }
    public function withTokenReroll() : TokenEntity{
        $newEntity = clone $this;
        $newEntity->_tokenStr = TokenFormat::generateToken();
        return $newEntity;
    }
    public function getRefreshTokenStr() : string{
        return $this->_refreshTokenStr;
    }
    public function withRefreshTokenStr(string $refreshTokenStr) : TokenEntity{
        if(!TokenFormat::isValidToken($refreshTokenStr)){
            throw new PDKInnerArgumentError('refreshTokenStr','this param is not formatted correctly');
        }
        $newEntity = clone $this;
        $newEntity->_refreshTokenStr = TokenFormat::formatToken($refreshTokenStr);
        return $newEntity;
    }
    public function withRefreshTokenReroll() : TokenEntity{
        $newEntity = clone $this;
        $newEntity->_refreshTokenStr = TokenFormat::generateToken();
        return $newEntity;
    }
    public function getRemoteAddr() : ?string{
        return $this->_remoteAddr;
    }
    public function setRemoteAddr(?string $remoteAddr){
        if(!empty($remoteAddr)){
            if(IPFormat::isIP($remoteAddr)){
                $this->_remoteAddr = IPFormat::formatIP($remoteAddr);
            }else{
                throw new PDKInnerArgumentError('remoteAddr','This IP Address is not formatted correctly');
            }
        }else{
            $this->_remoteAddr = null;
        }
    }
    public function getDeviceUA() : ?string{
        return $this->_deviceUA;
    }
    public function setDeviceUA(?string $deviceUA){
        $this->_deviceUA = empty($deviceUA) ? null : $deviceUA;
    } 
    public function isValid(int $currentTime) : bool{
        return $this->valid && $currentTime < $this->expireTime;
    }
    public function isRefreshValid(int $currentTime) : bool{
        return $this->valid && $currentTime < $this->refreshTokenExpireTime;
    }
}