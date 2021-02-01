<?php
namespace InteractivePlus\PDK2021Core\APP\APPToken;
class APPTokenObtainedMethod{
    const GRANTTYPE_WITH_SECRET_AUTH_CODE = 0;
    const GRANTTYPE_NO_SECRET_AUTH_CODE_PKCE = 1;
    public static function isValidObtainedMethod(int $method) : bool{
        return $method >= 0 && $method <= 1;
    }
    public static function fixObtainedMethod(int $method) : int{
        return self::isValidObtainedMethod($method) ? $method : self::GRANTTYPE_NO_SECRET_AUTH_CODE_PKCE;
    }
}