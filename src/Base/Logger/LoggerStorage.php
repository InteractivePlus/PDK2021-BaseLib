<?php
namespace InteractivePlus\PDK2021Core\Base\Logger;

use InteractivePlus\PDK2021Core\Base\Constants\APPSystemConstants;
use InteractivePlus\PDK2021Core\Base\Constants\UserSystemConstants;
use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerError;
use InteractivePlus\PDK2021Core\Base\Exception\PDKErrCode;
use InteractivePlus\PDK2021Core\Base\Exception\PDKException;

abstract class LoggerStorage extends \Psr\Log\AbstractLogger{
    /**
     * Adds a logEntity to the storage
     * @param logEntity logEntity to store
     */
    public abstract function addLogItem(LogEntity $logEntity) : bool;

    /**
     * Clears logEntitys that matches the searchResult
     * @param int $fromTime the time(UTC) that marks the start of the log date/time limit. 0/-1 means no limit
     * @param int $toTime the time(UTC) that marks the end of the log date/time limit. -1 means no limit
     * @param int $highestLogLevel @see \InteractivePlus\PDK2021Core\Base\Logger\PDKLogLevel
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError if there was an error deleting in the storage
     */
    public abstract function deleteLogItems(int $fromTime = -1, int $toTime = -1, int $highestLogLevel = PDKLogLevel::INFO) : void;

    /**
     * Searchs through the storage and see if any log records match the search parameters.
     * @param int $fromTime the time(UTC) that marks the start of the log date/time limit. 0/-1 means no limit
     * @param int $toTime the time(UTC) that marks the end of the log date/time limit. -1 means no limit
     * @param int $lowestLogLevel @see \InteractivePlus\PDK2021Core\Base\Logger\PDKLogLevel
     * @param int $offset start of the data
     * @param int $count how many log records do you want to fetch from $offset? -1 means all
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError if there was an error deleting in the storage
     * @return \InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult matching result
     */
    public abstract function getLogItemsBetween(int $fromTime = -1, int $toTime = -1, int $offset = 0, int $count = -1, int $lowestLogLevel = PDKLogLevel::NOTICE) : MultipleResult;

    public abstract function getLogCount(int $fromTime = -1, int $toTime = -1, int $lowestLogLevel = PDKLogLevel::NOTICE) : int;

    /**
     * Adds a PSR logEntity to the storage
     * @param string $level @see \Psr\Log\LogLevel
     * @param string/Object $message string/Obj with __toString() method, error message
     * @param array $context context of the error
     * @throws \InvalidArgumentException if the message param cannot be converted to string
     * @throws \InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKStorageEngineError if there was an error storing the LogEntity
     */
    public function log($level, $message, array $context = array()) : bool{
        $entity = NULL;
        try{
            $entity = new LogEntity(
                ActionID::PSRLog,
                APPSystemConstants::NO_APP_RELATED_APPUID,
                UserSystemConstants::NO_USER_RELATED_UID,
                time(),
                PDKLogLevel::fromPSRLogLevel($level),
                true,
                0,
                NULL,
                strval($message),
                empty($context) ? NULL : $context
            );
        }catch(\Exception $e){
            return false;
        }
        return $this->addLogItem(
            $entity
        );
    }
}