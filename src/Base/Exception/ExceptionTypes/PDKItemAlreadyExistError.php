<?php
namespace InteractivePlus\PDK2021\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021\Base\Exception\PDKException;

class PDKItemAlreadyExistError extends PDKException{
    private string $item;
    public function __construct(string $item, string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->item = $item;
        if(empty($message)){
            $message = 'Item ' . $item . ' already exist';
        }
        parent::__construct(PDKErrCode::ITEM_ALREADY_EXIST_ERROR,$message,$errParams,$previous);
    }
    public function toReponseJSON() : string{
        $response_Array = array(
            'errorCode' => $this->getCode(),
            'errorDescription' => $this->getMessage(),
            'errorParams' => $this->getErrorParams(),
            'errorFile' => $this->getFile(),
            'errorLine' => $this->getLine(),
            'item' => $this->item
        );
        return json_encode($response_Array);
    }
}