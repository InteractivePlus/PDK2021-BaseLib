<?php
namespace InteractivePlus\PDK2021Core\APP\APPInfo;

use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenScope;
use InteractivePlus\PDK2021Core\APP\APPToken\APPTokenScopes;

class APPPermission{
    public int $maxDataRecursionLevel;
    public int $maxCompressedDataLength;
    public int $maxUncompressedDataLength;
    public int $maxDataRecordNumber;
    public bool $canReadUserRealData;
    public bool $isOfficialAPP;
    public array $allowedScopes;
    
    public function __construct(
        int $maxDataRecursionLevel = 3, 
        int $maxCompressedDataLength = 256, 
        int $maxUncompressedDataLength = 256*2, 
        int $maxDataRecordNumber = 1000, //-1 = Unlimited
        array $allowedScopes = array('info','store_data'), //array(APPTokenScopes::SCOPE_BASIC_INFO()->getScopeName(),APPTokenScopes::SCOPE_STORE_DATA()->getScopeName())
        bool $canReadUserRealData = false,
        bool $isOfficialAPP = false 
    )
    {
        $this->maxDataRecursionLevel = $maxDataRecursionLevel;
        $this->maxCompressedDataLength = $maxCompressedDataLength;
        $this->maxUncompressedDataLength = $maxUncompressedDataLength;
        $this->maxDataRecordNumber = $maxDataRecordNumber;
        $this->allowedScopes = $allowedScopes;
        $this->canReadUserRealData = $canReadUserRealData;
        $this->isOfficialAPP = $isOfficialAPP;
    }
    public function allowScope(string $scope) : bool{
        return in_array(strtolower($scope),$this->allowedScopes);
    }
    public function filterScopes(array $scopeList) : array{
        $newArray = [];
        foreach($scopeList as $scope){
            if($this->allowScope($scope)){
                $newArray[] = $scope;
            }
        }
        return $newArray;
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
            'scopes' => $this->allowedScopes,
            'canReadUserRealData' => $this->canReadUserRealData,
            'isOfficial' => $this->isOfficialAPP
        );
    }
    public static function fromAssocArray(array $data) : APPPermission{
        $returnObj = new APPPermission();
        foreach($data as $dataKey => $dataVal){
            switch($dataKey){
                case 'maxRecursionLevel':
                    $returnObj->maxDataRecursionLevel = intval($dataVal);
                    break;
                case 'maxCompressedLen':
                    $returnObj->maxCompressedDataLength = intval($dataVal);
                    break;
                case 'maxUncompressedLen':
                    $returnObj->maxUncompressedDataLength = intval($dataVal);
                    break;
                case 'maxDataRecordNum':
                    $returnObj->maxDataRecordNumber = intval($dataVal);
                    break;
                case 'scopes':
                    if(is_array($dataVal)){
                        $returnObj->allowedScopes = $dataVal;
                    }
                    break;
                case 'canReadUserRealData':
                    if($dataVal && $dataVal !== false && strtolower($dataVal) !== 'false'){
                        $returnObj->canReadUserRealData = true;
                    }else{
                        $returnObj->canReadUserRealData = false;
                    }
                    break;
                case 'isOfficial':
                    if($dataVal && $dataVal !== false && strtolower($dataVal) !== 'false'){
                        $returnObj->isOfficialAPP = true;
                    }else{
                        $returnObj->isOfficialAPP = false;
                    }
                    break;
            }
        }
        return $returnObj;
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