<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKException;
use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;

class PDKInnerError extends PDKException{
    public function __construct(string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        parent::__construct(PDKErrCode::UNKNOWN_INNER_ERROR,$message,$errParams,$previous);
    }
}