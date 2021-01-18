<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKException;
use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;

class PDKPermissionDeniedError extends PDKException{
    public function __construct(string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        parent::__construct(PDKErrCode::PERMISSION_DENIED,$message,$errParams,$previous);
    }
}