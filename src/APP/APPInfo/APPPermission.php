<?php
namespace InteractivePlus\PDK2021Core\APP\APPInfo;

use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenScope;
use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenScopes;

class APPPermission{
    public int $maxDataRecursionLevel;
    public int $maxCompressedDataLength;
    public int $maxUncompressedDataLength;
    public int $maxDataRecordNumber; 
    public array $allowedScopes;
    
    public function __construct(
        int $maxDataRecursionLevel = 3, 
        int $maxCompressedDataLength = 256, 
        int $maxUncompressedDataLength = 256*2, 
        int $maxDataRecordNumber = 1000, //-1 = Unlimited
        array $allowedScopes = array(APPTokenScopes::SCOPE_BASIC_INFO()->getScopeName(),APPTokenScopes::SCOPE_SEND_NOTIFICATIONS()->getScopeName())
    )
    {
        $this->maxDataRecursionLevel = $maxDataRecursionLevel;
        $this->maxCompressedDataLength = $maxCompressedDataLength;
        $this->maxUncompressedDataLength = $maxUncompressedDataLength;
        $this->maxDataRecordNumber = $maxDataRecordNumber;
        $this->allowedScopes = $allowedScopes;
    }
    public function getCompressedData(array $assocArray) : ?string{
        if(!self::checkMaxRecursionLevel($assocArray,$this->maxDataRecursionLevel)){
            return null;
        }
        if(empty($assocArray)){
            return '';
        }
        $jsonEncoded = serialize($assocArray);
        if(strlen($jsonEncoded) > $this->maxUncompressedDataLength && $this->maxUncompressedDataLength >= 0){
            return null;
        }
        $compressedData = gzcompress($jsonEncoded);
        if(strlen($compressedData) > $this->maxCompressedDataLength && $this->maxCompressedDataLength >= 0){
            return null;
        }
        return $compressedData;
    }
    public static function getDecompressedData(?string $compressedData) : array{
        if(empty($compressedData)){
            return array();
        }
        try{
            return unserialize(gzuncompress($compressedData));
        }catch(\Exception $e){
            return array();
        }
    }
    public function toAssocArray() : array{
        return array(
            'maxRecursionLevel' => $this->maxDataRecursionLevel,
            'maxCompressedLen' => $this->maxCompressedDataLength,
            'maxUncompressedLen' => $this->maxUncompressedDataLength,
            'maxDataRecordNum' => $this->maxDataRecordNumber,
            'scopes' => $this->allowedScopes
        );
    }
    public static function fromAssocArray(array $data) : APPPermission{
        $maxRLevel = 3;
        $maxCompressedLen = 256;
        $maxUncompressedLen = 256*2;
        $maxRecordNum = 1000;
        $scopes = array(APPTokenScopes::SCOPE_BASIC_INFO()->getScopeName());
        foreach($data as $dataKey => $dataVal){
            switch($dataKey){
                case 'maxRecursionLevel':
                    $maxRLevel = intval($dataVal);
                    break;
                case 'maxCompressedLen':
                    $maxCompressedLen = intval($dataVal);
                    break;
                case 'maxUncompressedLen':
                    $maxUncompressedLen = intval($dataVal);
                    break;
                case 'maxDataRecordNum':
                    $maxRecordNum = intval($dataVal);
                    break;
                case 'scopes':
                    if(is_array($dataVal)){
                        $scopes = $dataVal;
                    }
                    break;
            }
        }
        return new APPPermission($maxRLevel,$maxCompressedLen,$maxUncompressedLen,$maxRecordNum,$scopes);
    }
    private static function checkMaxRecursionLevel(array $assocArray, int $maxLevel) : bool{
        if($maxLevel <= 1){
            return false;
        }
        foreach($assocArray as $arrayKey => $arrayEle){
            if(is_array($arrayEle)){
                $currentCheckRst = self::checkMaxRecursionLevel($arrayEle,$maxLevel - 1);
                if(!$currentCheckRst){
                    return false;
                }
            }
        }
        return true;
    }

}