<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;

class PDKItemNotFoundError extends PDKException{
    private string $item;
    public function __construct(string $item, string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->item = $item;
        if(empty($message)){
            $message = 'Item ' . $item . ' not found';
        }
        parent::__construct(PDKErrCode::ITEM_NOT_FOUND_ERROR,$message,$errParams,$previous);
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