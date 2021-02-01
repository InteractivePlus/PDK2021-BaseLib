<?php
namespace InteractivePlus\PDK2021Core\User\Setting;
class CombinedSetting extends UserSetting{
    public UserSetting $currentLevelSetting;
    public UserSetting $lowerLevelSetting;

    public function __construct(UserSetting $currentLevelSetting, UserSetting $lowerLevelSetting)
    {
        $this->currentLevelSetting = $currentLevelSetting;
        $this->lowerLevelSetting = $lowerLevelSetting;
    }
    public function allowNotificationEmails() : int{
        $currentLevelVal = $this->currentLevelSetting->allowNotificationEmails();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowNotificationEmails();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowNotificationEmails(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowNotificationEmails($userSettingBoolean);
    }
    public function allowSaleEmails() : int{
        $currentLevelVal = $this->currentLevelSetting->allowSaleEmails();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowSaleEmails();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowSaleEmails(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowSaleEmails($userSettingBoolean);
    }
    public function allowNotificationSMS() : int{
        $currentLevelVal = $this->currentLevelSetting->allowNotificationSMS();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowNotificationSMS();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowNotificationSMS(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowNotificationSMS($userSettingBoolean);
    }
    public function allowSaleSMS() : int{
        $currentLevelVal = $this->currentLevelSetting->allowSaleSMS();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowSaleSMS();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowSaleSMS(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowSaleSMS($userSettingBoolean);
    }
    public function allowNotificationCall() : int{
        $currentLevelVal = $this->currentLevelSetting->allowNotificationCall();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowNotificationCall();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowNotificationCall(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowNotificationCall($userSettingBoolean);
    }
    public function allowSaleCall() : int{
        $currentLevelVal = $this->currentLevelSetting->allowSaleCall();
        if($currentLevelVal === SettingBoolean::INHERIT){
            return $this->lowerLevelSetting->allowSaleCall();
        }else{
            return $currentLevelVal;
        }
    }
    public function setAllowSaleCall(int $userSettingBoolean) : void{
        $this->currentLevelSetting->setAllowSaleCall($userSettingBoolean);
    }
}