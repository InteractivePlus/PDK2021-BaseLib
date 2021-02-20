<?php
namespace InteractivePlus\PDK2021Core\APP\AuthCode;

use InteractivePlus\PDK2021Core\APP\APPInfo\PDKAPPType;
use InteractivePlus\PDK2021Core\APP\Formats\APPFormat;
use InteractivePlus\PDK2021Core\APP\Formats\MaskIDFormat;
use InteractivePlus\PDK2021Core\APP\MaskID\MaskIDEntity;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;

class AuthCodeEntity{
    private string $_auth_code;
    public int $appUID;
    private string $_maskid;
    public int $issueTime;
    public int $expireTime;
    public array $scopes;
    public ?string $codeChallenge;
    private int $_challengeType;
    public bool $used;

    public function __construct(
        ?string $auth_code,
        int $appUID, 
        string $maskid, 
        int $issueTime, 
        int $expireTime, 
        array $scopes, 
        ?string $codeChallenge, 
        int $challengeType = AuthCodeChallengeType::SHA256, 
        bool $used = false
    )
    {
        if(!APPFormat::isValidAuthCode($auth_code)){
            throw new PDKInnerArgumentError('auth_code');
        }
        if(!MaskIDFormat::isValidMaskID($maskid)){
            throw new PDKInnerArgumentError('maskid');
        }
        $this->_auth_code = empty($auth_code) ? APPFormat::generateAuthCode() : $auth_code;
        $this->appUID = $appUID;
        $this->setMaskID($maskid);
        $this->issueTime = $issueTime;
        $this->expireTime = $expireTime;
        $this->scopes = $scopes;
        $this->codeChallenge = $codeChallenge;
        $this->_challengeType = AuthCodeChallengeType::fixChallengeType($challengeType);
        $this->used = $used;
    }

    public function getAuthCodeStr() : string{
        return $this->_auth_code;
    }
    public function withAuthCodeStr(string $authCodeStr) : AuthCodeEntity{
        if(!APPFormat::isValidAuthCode($authCodeStr)){
            throw new PDKInnerArgumentError('authCodeStr');
        }
        $newEntity = clone $this;
        $newEntity->_auth_code = $authCodeStr;
        return $newEntity;
    }
    public function withAuthCodeReroll() : AuthCodeEntity{
        $newEntity = clone $this;
        $newEntity->_auth_code = APPFormat::generateAuthCode();
        return $newEntity;
    }
    public function getChallengeType() : int{
        return $this->_challengeType;
    }
    public function setChallengeType(int $challengeType) : void{
        $this->_challengeType = AuthCodeChallengeType::fixChallengeType($challengeType);
    }
    public function checkCodeVerifier(?string $codeVerifier) : bool{
        switch($this->_challengeType){
            case AuthCodeChallengeType::NO_CHALLENGE:
                return true;
                break;
            case AuthCodeChallengeType::PLAIN:
                return $this->codeChallenge === $codeVerifier;
                break;
            default: //case AuthCodeChallengeType::SHA256:
                if(empty($codeVerifier)){
                    return false;
                }
                return APPFormat::isChallengeS256StringEqual($this->codeChallenge, APPFormat::generateChallengeS256String($codeVerifier));
        }
    }
    public function getMaskID() : string{
        return $this->_maskid;
    }
    public function setMaskID(string $maskID) : void{
        if(!MaskIDFormat::isValidMaskID($maskID)){
            throw new PDKInnerArgumentError('maskID');
        }
        $this->_maskid = MaskIDFormat::formatMaskID($maskID);
    }
}