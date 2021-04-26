<?php
namespace InteractivePlus\PDK2021Core\APP\APPInfo;

use InteractivePlus\PDK2021Core\APP\APPSystemFormatSetting;
use InteractivePlus\PDK2021Core\APP\Formats\APPFormat;
use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;

class APPEntity{
    private int $_appuid;
    private ?string $_displayName;
    private string $_client_id;
    private string $_client_secret;
    private int $_client_type;
    public ?string $redirectURI;
    public int $createTime;
    public int $ownerUID;
    private ?APPSystemFormatSetting $_formatSetting = null;
    private APPPermission $_permission;

    public static function fromDatabase(
        int $appuid, 
        ?string $displayName, 
        string $client_id, 
        string $client_secret, 
        int $client_type, 
        ?string $redirectURI, 
        int $createTime, 
        int $ownerUID, 
        ?APPSystemFormatSetting $formatSetting,
        APPPermission $permission
    ) : APPEntity{
        $newAPP = new APPEntity($appuid,$displayName,$client_id,$client_secret,$client_type,$redirectURI,$createTime,$ownerUID,$formatSetting,$permission);
        $newAPP->setClientType($client_type);
        return $newAPP;
    }

    public static function create(
        ?string $displayName, 
        int $client_type, 
        ?string $redirectURI, 
        int $createTime, 
        int $ownerUID, 
        ?APPSystemFormatSetting $formatSetting,
        APPPermission $permission
    ) : APPEntity{
        if(!empty($displayName) && $formatSetting !== null && !$formatSetting->checkAPPDisplayName($displayName)){
            throw new PDKInnerArgumentError('displayName');
        }
        $newAPP = new APPEntity(APPSystemConstants::NO_APP_RELATED_APPUID,$displayName,APPFormat::generateAPPID(),APPFormat::generateAPPSecert(),$client_type,$redirectURI,$createTime,$ownerUID,$formatSetting,$permission);
        $newAPP->setClientType($client_type);
        return $newAPP;
    }

    private function __construct(int $appuid, ?string $displayName, string $client_id, string $client_secret, int $client_type, ?string $redirectURI, int $createTime, int $ownerUID, ?APPSystemFormatSetting $formatSetting, APPPermission $permission){
        $this->_appuid = $appuid;
        $this->_displayName = $displayName;
        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;
        $this->_client_type = $client_type;
        $this->redirectURI = $redirectURI;
        $this->createTime = $createTime;
        $this->ownerUID = $ownerUID;
        $this->_formatSetting = $formatSetting;
        $this->_permission = $permission;
    }

    public function getAPPUID() : int{
        return $this->_appuid;
    }

    public function withAPPUID(int $uid) : APPEntity{
        $newEntity = clone $this;
        $newEntity->_appuid = $uid;
        return $newEntity;
    }

    public function getDisplayName() : ?string{
        return $this->_displayName;
    }

    public function setDisplayName(?string $displayName) : void{
        if(empty($displayName)){
            $this->_displayName = null;
            return;
        }
        if($this->_formatSetting !== null && !$this->_formatSetting->checkAPPDisplayName($displayName)){
            throw new PDKInnerArgumentError('displayName');
            return;
        }
        $this->_displayName = $displayName;
    }

    public function getClientID() : string{
        return $this->_client_id;
    }

    public function setClientID(string $clientID) : void{
        if(!APPFormat::isValidAPPID($clientID)){
            throw new PDKInnerArgumentError('clientID');
            return;
        }
        $this->_client_id = APPFormat::formatAPPID($clientID);
    }

    public function doClientIDReroll() : void{
        $this->_client_id = APPFormat::generateAPPID();
    }

    public function getClientSecret() : string{
        return $this->_client_secret;
    }

    public function checkClientSecret(string $secretToCheck) : bool{
        return APPFormat::isAPPSecertStringEqual($this->_client_secret,$secretToCheck);
    }

    public function setClientSecret(string $clientSecret) : void{
        if(!APPFormat::isValidAPPSecert($clientSecret)){
            throw new PDKInnerArgumentError('clientSecret');
            return;
        }
        $this->_client_secret = APPFormat::formatAPPSecert($clientSecret);
    }

    public function doClientSecretReroll() : void{
        $this->_client_secret = APPFormat::generateAPPSecert();
    }

    public function getClientType() : int{
        return $this->_client_type;
    }

    public function setClientType(int $type) : void{
        $this->_client_type = PDKAPPType::fixAppType($type);
    }

    public function canUsePKCEGrant() : bool{
        return $this->_client_type === PDKAPPType::NO_BACKEND || $this->_client_type === PDKAPPType::EITHER;
    }

    public function canUseServerGrant() : bool{
        return $this->_client_type === PDKAPPType::HAS_BACKEND || $this->_client_type === PDKAPPType::EITHER;
    }

    public function checkRedirectURI(string $passedRedirectURI) : bool{
        if(empty($this->redirectURI)){
            return true;
        }else{
            return $passedRedirectURI === $this->redirectURI;
        }
    }

    public function getFormatClass() : ?APPSystemFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatClass(?APPSystemFormatSetting $class = null) : void{
        $this->_formatSetting = $class;
    }

    public function getPermission() : APPPermission{
        return $this->_permission;
    }

    public function setPermission(APPPermission $permission) : void{
        $this->_permission = $permission;
    }

}