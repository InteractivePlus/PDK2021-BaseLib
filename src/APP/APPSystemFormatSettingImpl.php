<?php
namespace InteractivePlus\PDK2021Core\APP;
class APPSystemFormatSettingImpl implements APPSystemFormatSetting{
    private int $_appDisplayNameMin;
    private int $_appDisplayNameMax;
    public function __construct(
        int $appDisplayNameMin,
        int $appDisplayNameMax,
    )
    {
        $this->_appDisplayNameMin = $appDisplayNameMin;
        $this->_appDisplayNameMax = $appDisplayNameMax;
    }
    public function getAPPDisplayNameMinLen(): int
    {
        return $this->_appDisplayNameMin;
    }
    public function getAPPDisplayNameMaxLen(): int
    {
        return $this->_appDisplayNameMax;
    }
    public function checkAPPDisplayName(string $appDisplayName): bool
    {
        return strlen($appDisplayName) >= $this->getAPPDisplayNameMinLen() && strlen($appDisplayName) <= $this->getAPPDisplayNameMaxLen();
    }
}