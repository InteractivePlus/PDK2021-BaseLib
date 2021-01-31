<?php
namespace InteractivePlus\PDK2021Core\User\Setting;
class UserSetting{
    private int $_allowNotificationEmails;
    private int $_allowSaleEmails;
    private int $_allowNotificationSMS;
    private int $_allowSaleSMS;
    private int $_allowNotificationCall;
    private int $_allowSaleCall;
    public function __construct(
        int $allowNotificationEmails,
        int $allowSaleEmails,
        int $allowNotificationSMS,
        int $allowSaleSMS,
        int $allowNotificationCall,
        int $allowSaleCall
    ){
        $this->setAllowNotificationEmails($allowNotificationEmails);
        $this->setAllowSaleEmails($allowSaleEmails);
        $this->setAllowNotificationSMS($allowNotificationSMS);
        $this->setAllowSaleSMS($allowSaleSMS);
        $this->allowNotificationCall($allowNotificationCall);
        $this->allowSaleCall($allowSaleCall);
    }
    public function allowNotificationEmails() : int{
        return $this->_allowNotificationEmails;
    }
    public function setAllowNotificationEmails(int $userSettingBoolean) : void{
        $this->_allowNotificationEmails = SettingBoolean::fixSetting($userSettingBoolean);
    }
    public function allowSaleEmails() : int{
        return $this->_allowSaleEmails;
    }
    public function setAllowSaleEmails(int $userSettingBoolean) : void{
        $this->_allowSaleEmails = SettingBoolean::fixSetting($userSettingBoolean);
    }
    public function allowNotificationSMS() : int{
        return $this->_allowNotificationSMS;
    }
    public function setAllowNotificationSMS(int $userSettingBoolean) : void{
        $this->_allowNotificationSMS = SettingBoolean::fixSetting($userSettingBoolean);
    }
    public function allowSaleSMS() : int{
        return $this->_allowSaleSMS;
    }
    public function setAllowSaleSMS(int $userSettingBoolean) : void{
        $this->_allowSaleSMS = SettingBoolean::fixSetting($userSettingBoolean);
    }
    public function allowNotificationCall() : int{
        return $this->_allowNotificationCall;
    }
    public function setAllowNotificationCall(int $userSettingBoolean) : void{
        $this->_allowNotificationCall = SettingBoolean::fixSetting($userSettingBoolean);
    }
    public function allowSaleCall() : int{
        return $this->_allowSaleCall;
    }
    public function setAllowSaleCall(int $userSettingBoolean) : void{
        $this->_allowSaleCall = SettingBoolean::fixSetting($userSettingBoolean);
    }
}