<?php
namespace InteractivePlus\PDK2021Core\Base\Exception;

use ReflectionClass;

class PDKErrCode{
    const NO_ERROR = 0;
    const UNKNOWN_INNER_ERROR = 1;
    const STORAGE_ENGINE_ERROR = 2;
    const INNER_ARGUMENT_ERROR = 3;
    const SENDER_SERVICE_ERROR = 4;
    const ITEM_NOT_FOUND_ERROR = 10;
    const ITEM_ALREADY_EXIST_ERROR = 11;
    const ITEM_EXPIRED_OR_USED_ERROR = 12;
    const PERMISSION_DENIED = 13;
    const CREDENTIAL_NOT_MATCH = 14;
    const REQUEST_PARAM_FORMAT_ERROR = 20;

    /**
     * get an error code's name
     * @param int $errCode int value of the errCode
     * @return ?string Name of the error code, returns NULL if not found.
     */
    public static function getErrCodeName(int $errCode) : ?string{
        $reflectionCls = new ReflectionClass(__NAMESPACE__ . '\\' . __CLASS__);
        $constants = $reflectionCls->getConstants();
        $flippedConstants = array_flip($constants);
        return $flippedConstants[$errCode];
    }
    
    /**
     * get an error code by its name
     * @param string $errCodeName name of the errCode
     * @return int -1 if not found
     */
    public static function getErrCodeByName(string $errCodeName) : int{
        $reflectionCls = new ReflectionClass(__NAMESPACE__ . '\\' . __CLASS__);
        $constants = $reflectionCls->getConstants();
        return $constants[$errCodeName] === NULL ? -1 : $constants[$errCodeName];
    }
}