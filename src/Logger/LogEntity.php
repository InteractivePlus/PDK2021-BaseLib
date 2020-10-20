<?php
namespace InteractivePlus\PDK2021Base\Logger;
class LogEntity{
    public int $actionID = 0;
    private int $_appuid = 0;
    private int $_uid = 0;
    public int $time = 0;
    private int $_logLevel = PDKLogLevel::INFO;
    public ?string $message = NULL;
    public bool $success = false;
    public int $PDKExceptionCode = 0;
    private ?array $_context = array();
    public ?string $clientAddr = NULL;

    public function __construct(
        int $actionID, 
        int $appUID, 
        int $uid,
        int $time, 
        int $logLevel, 
        bool $success,
        int $PDKExceptionCode = 0,
        ?string $clientAddr = NULL,
        ?string $message = NULL, 
        ?array $context = NULL
    ){
        $this->actionID = $actionID;
        $this->_appuid = $appUID;
        $this->_uid = $uid;
        $this->time = $time;
        $this->_logLevel = PDKLogLevel::fixLogLevel($logLevel);
        $this->success = $success;
        $this->PDKExceptionCode = $PDKExceptionCode;
        $this->clientAddr = $clientAddr;
        $this->message = $message;
        $this->_context = $context;
    }
    public function getAPPUID() : int{
        return $this->_appuid;
    }
    public function withAPPUID(int $appuid) : LogEntity{
        $clonedEntity = clone $this;
        $clonedEntity->_appuid = $appuid;
        return $clonedEntity;
    }
    public function getUID() : int{
        return $this->_uid;
    }
    public function withUID(int $uid) : LogEntity{
        $clonedEntity = clone $this;
        $clonedEntity->_uid = $uid;
        return $clonedEntity;
    }
    public function getLogLevel() : int{
        return $this->_logLevel;
    }
    public function withLogLevel(int $logLevel) : LogEntity{
        $clonedEntity = clone $this;
        $clonedEntity->_logLevel = PDKLogLevel::fixLogLevel($logLevel);
        return $clonedEntity;
    }
    public function getContexts() : array{
        return $this->_context;
    }
    public function withContexts(?array $newContext) : LogEntity{
        $clonedEntity = clone $this;
        $clonedEntity->_context = $newContext;
        return $clonedEntity;
    }
    public function getContext(string $key){
        return $this->_context[$key];
    }
    public function withContext(string $key, $val) : LogEntity{
        $clonedEntity = clone $this;
        if($val === NULL){
            unset($clonedEntity->_context);
        }else{
            $clonedEntity->_context[$key] = $val;
        }
        return $clonedEntity;
    }
    public function withDeleteContext(string $key) : LogEntity{
        return $this->withContext($key,NULL);
    }
}