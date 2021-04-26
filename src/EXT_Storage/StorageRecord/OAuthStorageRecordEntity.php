<?php
namespace InteractivePlus\PDK2021Core\EXT_Storage\StorageRecord;

use InteractivePlus\PDK2021Core\APP\APPInfo\APPPermission;
use InteractivePlus\PDK2021Core\APP\Formats\APPFormat;
use InteractivePlus\PDK2021Core\APP\Formats\MaskIDFormat;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKPermissionDeniedError;

class OAuthStorageRecordEntity{
    private string $_mask_id;
    private string $_client_id;
    public int $appuid;
    private ?string $compressedData;
    public int $created;
    public int $lastUpdated;

    private function __construct(
        string $maskID,
        string $clientID,
        int $appuid,
        ?string $compressedData,
        int $created,
        int $lastUpdated
    )
    {
        $this->setMaskID($maskID);
        $this->setClientID($clientID);
        $this->appuid = $appuid;
        $this->compressedData = $compressedData;
        $this->created = $created;
        $this->lastUpdated = $lastUpdated;
    }
    public static function fromDataBase(string $maskID, string $clientID, int $appuid, ?string $compressedData, int $created,int $lastUpdated) : OAuthStorageRecordEntity{
        $createdObj = new OAuthStorageRecordEntity($maskID,$clientID,$appuid,$compressedData, $created, $lastUpdated);
        return $createdObj;
    }
    public static function create(string $maskID, string $clientID, int $appuid, array $data, APPPermission $permission, int $time) : OAuthStorageRecordEntity{
        $compressedData = $permission->getCompressedData($data);
        if($compressedData === null){
            throw new PDKPermissionDeniedError('the data is too big or does not match our format rules');
        }
        $createdObj = new OAuthStorageRecordEntity($maskID,$clientID,$appuid,$compressedData,$time,$time);
        return $createdObj;
    }
    public function getMaskID() : string{
        return $this->_mask_id;
    }
    public function setMaskID(string $mask_id) : void{
        if(!MaskIDFormat::isValidMaskID($mask_id)){
            throw new PDKInnerArgumentError('mask_id');
        }
        $this->_mask_id = MaskIDFormat::formatMaskID($mask_id);
    }
    public function getClientID() : string{
        return $this->_client_id;
    }
    public function setClientID(string $client_id) : void{
        if(!APPFormat::isValidAPPID($client_id)){
            throw new PDKInnerArgumentError('client_id');
        }
        $this->_client_id = APPFormat::formatAPPID($client_id);
    }
    public function getCompressedData() : string{
        return $this->compressedData;
    }
    public function getData() : array{
        return APPPermission::getDecompressedData($this->compressedData);
    }
    public function setData(array $data, APPPermission $permission) : void{
        $compressedData = $permission->getCompressedData($data);
        if($compressedData === null){
            throw new PDKPermissionDeniedError('the data is too big or does not match our format rules');
        }
        $this->compressedData = $compressedData;
    }
}