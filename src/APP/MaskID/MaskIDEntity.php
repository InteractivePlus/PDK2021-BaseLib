<?php
namespace InteractivePlus\PDK2021Core\APP\MaskID;

use InteractivePlus\PDK2021Core\APP\Format\MaskIDFormat;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\User\Setting\CombinedSetting;
use InteractivePlus\PDK2021Core\User\Setting\UserSetting;
use InteractivePlus\PDK2021Core\User\UserInfo\UserEntity;

class MaskIDEntity{
    private string $_maskID;
    public int $appuid;
    public int $uid;
    private ?string $_displayName;
    public int $createTime;
    private UserSetting $_setting;
    public function __construct(string $maskID, int $appuid, int $uid, ?string $displayName, int $createTime, UserSetting $setting)
    {
        if(!MaskIDFormat::isValidMaskID($maskID)){
            throw new PDKInnerArgumentError('maskID');
        }
        $this->_maskID = $maskID;
        $this->appuid = $appuid;
        $this->setDisplayName($displayName);
        $this->createTime = $createTime;
        $this->uid = $uid;
        $this->_setting = $setting;
    }
    public function getMaskID() : string{
        return $this->_maskID;
    }
    public function withMaskID(string $maskID) : MaskIDEntity{
        if(!MaskIDFormat::isValidMaskID($maskID)){
            throw new PDKInnerArgumentError('maskID');
        }
        $newEntity = clone $this;
        $newEntity->_maskID = MaskIDFormat::formatMaskID($maskID);
        return $newEntity;
    }
    public function withMaskIDReroll() : MaskIDEntity{
        return $this->withMaskID(MaskIDFormat::generateMaskID());
    }
    public function getDisplayName() : ?string{
        return $this->_displayName;
    }
    public function setDisplayName(string $displayName) : void{
        if(!MaskIDFormat::isValidMaskIDDisplayName($displayName)){
            throw new PDKInnerArgumentError('displayName');
        }
        $this->_displayName = $displayName;
    }
    public function getSettings() : UserSetting{
        return $this->_setting;
    }
    public function setSettings(UserSetting $setting) : void{
        $this->_setting = $setting;
    }
    public function getCombinedSettings(UserEntity $userEntity) : UserSetting{
        return new CombinedSetting($this->_setting,$userEntity->getCombinedSettings());
    }
}