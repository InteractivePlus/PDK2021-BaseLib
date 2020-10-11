<?php
namespace InteractivePlus\PDK2021Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Base\Exception\PDKException;

class PDKInnerArgumentError extends PDKException{
    public function __construct(string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->err_params = $errParams;
        parent::__construct(PDKErrCode::INNER_ARGUMENT_ERROR,$message,$errParams,$previous);
    }
}