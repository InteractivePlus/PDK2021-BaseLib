<?php
namespace InteractivePlus\PDK2021Core\APP;
interface APPSystemFormatSetting{
    public function getAPPDisplayNameMinLen() : int;
    public function getAPPDisplayNameMaxLen() : int;
    public function checkAPPDisplayName(string $appDisplayName) : bool;
}