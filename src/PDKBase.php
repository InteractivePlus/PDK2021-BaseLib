<?php
namespace InteractivePlus\PDK2021Base;

use InteractivePlus\PDK2021Base\Logger\LoggerStorage;

class PDKBase{
    private LoggerStorage $universalLogger;
    public function __construct(LoggerStorage $loggerStorage){
        $this->universalLogger = $loggerStorage;
    }
    public function getLogger() : LoggerStorage{
        return $this->universalLogger;
    }
}