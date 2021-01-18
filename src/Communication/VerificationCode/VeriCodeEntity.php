<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Formats\IPFormat;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\SentMethod;

class VeriCodeEntity{
    protected static function fixParamToMatchVeriCodeID(VeriCodeID $veriCodeID, ?array $param) : ?array{
        if(empty($param)){
            return null;
        }
        $newParam = array();
        $mProperty = $veriCodeID->getProperty();
        foreach($param as $paramKey => $paramVal){
            if($mProperty->isParamNameAssociatedOrRequired($paramKey)){
                $newParam[$paramKey] = $paramVal;
            }
        }
        return $newParam;
    }

    private VeriCodeID $veriCodeID;
    private ?array $param = null;
    private ?string $triggerClientIP = null;
    private string $veriCodeStr;
    private int $issueUTCTime = 0;
    private int $expireUTCTime = 0;
    private int $sentMethod = SentMethod::NOT_SENT;
    private bool $used = false;
    private int $related_uid = 0;
    private int $related_appuid = 0;

    public function __construct(
        VeriCodeID $veriCodeID,
        int $issueUTCTime,
        int $expireUTCTime,
        int $related_uid,
        int $related_appuid = 0,
        ?array $param = null,
        ?string $triggerClientIP = null,
        ?string $customVeriCodeStrOverride = null,
        int $sentMethod = SentMethod::NOT_SENT,
        bool $used = false
    ){
        if(!empty($customVeriCodeStrOverride) && !VeriCodeFormat::isValidVerificationCode($customVeriCodeStrOverride)){
            throw new PDKInnerArgumentError('customVeriCodeStrOverride');
        }
        if(!empty($triggerClientIP) && !IPFormat::isIP($triggerClientIP)){
            throw new PDKInnerArgumentError('triggerClientIP');
        }
        if(!SentMethod::isSentMethodValid($sentMethod)){
            throw new PDKInnerArgumentError('sentMethod');
        }
        $actualVeriCodeStr = null;
        if(!empty($customVeriCodeStrOverride)){
            $actualVeriCodeStr = $customVeriCodeStrOverride;
        }else{
            $actualVeriCodeStr = VeriCodeFormat::generateVerificationCode();
        }
        $this->veriCodeID = $veriCodeID;
        $this->param = $param;
        $this->triggerClientIP = $triggerClientIP;
        $this->veriCodeStr = $actualVeriCodeStr;
        $this->issueUTCTime = $issueUTCTime;
        $this->expireUTCTime = $expireUTCTime;
        $this->sentMethod = $sentMethod;
        $this->used = $used;
        $this->related_uid = $related_uid;
        $this->related_appuid = $related_appuid;
    }

    public function getVeriCodeID() : VeriCodeID{
        return $this->veriCodeID;
    }
    
    /**
     * Get a new instance of VeriCodeEntity with a new VeriCode ID
     * @see \InteracttivePlus\PDK2021Communication\VerificationCode\VeriCodeID
     * @param int $veriCodeID int value defined in VeriCodeID class constant
     * @throws \InteracitvePlus\PDK2021Base\Exception\ExceptionTypes\PDKInnerArgumentError when the VeriCodeID is not a valid VeriCodeID
     * @return VeriCodeEntity new VeriCodeEntity instance
     */
    public function withVeriCodeID(int $veriCodeID) : VeriCodeEntity{
        if(!VeriCodeIDs::isValidVeriCodeID($veriCodeID)){
            throw new PDKInnerArgumentError('veriCodeID');
        }
        $newEntity = clone $this;
        $newEntity->veriCodeID = $veriCodeID;
        $newEntity->param = self::fixParamToMatchVeriCodeID($newEntity->veriCodeID,$newEntity->param);
        return $newEntity;
    }

    public function getVeriCodeParams() : ?array{
        return $this->param;
    }

    public function withVeriCodeParams(?array $params) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->param = empty($params) ? null : $params;
        $newEntity->param = self::fixParamToMatchVeriCodeID($newEntity->veriCodeID,$newEntity->param);
        return $newEntity;
    }

    public function getVeriCodeParam(string $name){
        return $this->param[$name];
    }

    public function withVeriCodeParam(string $name, $value) : VeriCodeEntity{
        $newEntity = clone $this;
        $mProperty = $newEntity->veriCodeID->getProperty();
        if(!$mProperty->isParamNameAssociatedOrRequired($name)){
            return $newEntity;
        }
        if($value === null){
            unset($newEntity->param[$name]);
        }else{
            $newEntity->param[$name] = $value;
        }
        return $newEntity;
    }

    public function getTriggerClientIP() : ?string{
        return $this->triggerClientIP;
    }

    public function withTriggerClientIP(?string $clientIP) : VeriCodeEntity{
        if(!IPFormat::isIP($clientIP)){
            throw new PDKInnerArgumentError('clientIP');
        }
        $newEntity = clone $this;
        $newEntity->triggerClientIP = IPFormat::formatIP($clientIP);
        return $newEntity;
    }

    public function checkClientIP(string $clientIP) : bool{
        if(empty($this->triggerClientIP)){
            return false;
        }
        return IPFormat::ipAddressEquals($this->triggerClientIP,$clientIP);
    }
    
    public function getVeriCodeString() : string{
        return $this->veriCodeStr;
    }

    public function getVeriCodePartialPhoneCode() : string{
        return VeriCodeFormat::getPartialPhoneCode($this->getVeriCodeString());
    }

    public function withVeriCodeString(string $veriCodeString) : VeriCodeEntity{
        if(!VeriCodeFormat::isValidVerificationCode($veriCodeString)){
            throw new PDKInnerArgumentError('veriCodeString');
        }
        $newEntity = clone $this;
        $newEntity->veriCodeStr = VeriCodeFormat::formatVerificationCode($veriCodeString);
        return $newEntity;
    }

    public function withVeriCodeStringReroll() : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->veriCodeStr = VeriCodeFormat::generateVerificationCode();
        return $newEntity;
    }

    public function checkVeriCodeString(string $veriCodeStrToCheck) : bool{
        return VeriCodeFormat::isVeriCodeStringEqual($this->veriCodeStr,$veriCodeStrToCheck);
    }

    public function checkPartialPhoneCode(string $partialPhoneCodeToCheck) : bool{
        return VeriCodeFormat::isPartialPhoneCodeEqual($this->getVeriCodePartialPhoneCode(),$partialPhoneCodeToCheck);
    }

    public function getIssueUTCTime() : int{
        return $this->issueUTCTime;
    }

    public function withIssueUTCTime(int $issueUTCTime) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->issueUTCTime = $issueUTCTime;
        return $newEntity;
    }

    public function getExpireUTCTime() : int{
        return $this->expireUTCTime;
    }

    public function withExpireUTCTime(int $expireUTCTime) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->expireUTCTime = $expireUTCTime;
        return $newEntity;
    }

    public function getSentMethod() : int{
        return $this->sentMethod;
    }

    public function withSentMethod(int $sentMethod) : VeriCodeEntity{
        if(!SentMethod::isSentMethodValid($sentMethod)){
            throw new PDKInnerArgumentError('sentMethod');
        }
        $newEntity = clone $this;
        $newEntity->sentMethod = $sentMethod;
        return $newEntity;
    }
    
    public function isVeriCodeUsed() : bool{
        return $this->used;
    }

    public function withVeriCodeUsed(bool $used) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->used = $used;
        return $newEntity;
    }

    public function getUID() : int{
        return $this->related_uid;
    }

    public function withUID(int $uid) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->related_uid = $uid;
        return $newEntity;
    }

    public function getAPPUID() : int{
        return $this->related_appuid;
    }

    public function withAPPUID(int $appuid) : VeriCodeEntity{
        $newEntity = clone $this;
        $newEntity->related_appuid = $appuid;
        return $newEntity;
    }

    public function canUse(int $currentTime) : bool{
        return (!$this->isVeriCodeUsed()) && ($currentTime < $this->getExpireUTCTime());
    }
}