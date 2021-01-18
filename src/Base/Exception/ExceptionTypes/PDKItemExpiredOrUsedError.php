<?php
namespace InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes;

use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;

class PDKItemExpiredOrUsedError extends PDKException{
    private string $item;
    public function __construct(string $item, string $message = '', ?array $errParams = null, ?\Exception $previous = null){
        $this->item = $item;
        if(empty($message)){
            $message = 'Item ' . $item . ' expired or used';
        }
        parent::__construct(PDKErrCode::ITEM_EXPIRED_OR_USED_ERROR,$message,$errParams,$previous);
    }
    public function toReponseJSON() : array{
        $response_Array = array(
            'errorCode' => $this->getCode(),
            'errorDescription' => $this->getMessage(),
            'errorParams' => $this->getErrorParams(),
            'errorFile' => $this->getFile(),
            'errorLine' => $this->getLine(),
            'item' => $this->item
        );
        return $response_Array;
    }
}