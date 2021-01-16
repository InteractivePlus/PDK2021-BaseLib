<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;

class PDKRequestParamFormatError extends PDKException{
    private string $param;
    public function __construct(string $param, string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->param = $param;
        if(empty($message)){
            $message = 'Request Parameter ' . $param . ' received an invalid input';
        }
        parent::__construct(PDKErrCode::REQUEST_PARAM_FORMAT_ERROR,$message,$errParams,$previous);
    }
    public function toReponseJSON() : string{
        $response_Array = array(
            'errorCode' => $this->getCode(),
            'errorDescription' => $this->getMessage(),
            'errorParams' => $this->getErrorParams(),
            'errorFile' => $this->getFile(),
            'errorLine' => $this->getLine(),
            'errorParam' => $this->param
        );
        return json_encode($response_Array);
    }
}