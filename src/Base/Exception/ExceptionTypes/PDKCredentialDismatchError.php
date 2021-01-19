<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;

class PDKCredentialDismatchError extends PDKException{
    private string $param;
    public function __construct(string $param, string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->param = $param;
        if(empty($message)){
            $message = 'Credential ' . $param . ' does not match with our record';
        }
        parent::__construct(PDKErrCode::CREDENTIAL_NOT_MATCH,$message,$errParams,$previous);
    }
    public function toReponseJSON() : array{
        $response_Array = array(
            'errorCode' => $this->getCode(),
            'errorDescription' => $this->getMessage(),
            'errorParams' => $this->getErrorParams(),
            'errorFile' => $this->getFile(),
            'errorLine' => $this->getLine(),
            'credential' => $this->param
        );
        return $response_Array;
    }
}