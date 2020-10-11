<?php
namespace InteractivePlus\PDK2021Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Base\Exception\PDKException;
use InteractivePlus\PDK2021Base\Exception\PDKErrCode;

class PDKInnerError extends PDKException{
    public function __construct(string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->err_params = $errParams;
        parent::__construct(PDKErrCode::UNKNOWN_INNER_ERROR,$message,$errParams,$previous);
    }
}