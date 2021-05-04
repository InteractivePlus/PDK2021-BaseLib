<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket\TicketRecord;

use InteractivePlus\PDK2021Core\APP\Formats\APPFormat;
use InteractivePlus\PDK2021Core\APP\Formats\MaskIDFormat;
use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\EXT_Ticket\OAuthTicketFormat;
use InteractivePlus\PDK2021Core\EXT_Ticket\OAuthTicketFormatSetting;

class OAuthTicketRecordEntity{
    private string $_ticketTitle;
    public array $contentListing;
    private string $_ticketID;
    public int $appuid;
    private ?string $_client_id;
    public int $uid;
    private ?string $_mask_id;
    private ?string $_access_token;
    public bool $isUrgent;
    public int $createTime;
    public int $lastUpdateTime;
    private OAuthTicketFormatSetting $_formatSetting;
    public function __construct(
        string $ticketTitle,
        array $contentListing,
        string $ticketID,
        int $appuid,
        ?string $clientID,
        int $uid,
        ?string $maskID,
        ?string $accessToken,
        bool $isUrgent,
        int $createTime,
        int $lastUpdateTime,
        OAuthTicketFormatSetting $formatSetting
    )
    {
        $this->_formatSetting = $formatSetting;
        $this->setTicketTitle($ticketTitle);
        $this->contentListing = $contentListing;
        $this->setTicketID($ticketID);
        $this->appuid = $appuid;
        $this->setClientID($clientID);
        $this->uid = $uid;
        $this->setMaskID($maskID);
        $this->setAccessToken($accessToken);
        $this->isUrgent = $isUrgent;
        $this->createTime = $createTime;
        $this->lastUpdateTime = $lastUpdateTime;
    }
    public function getTicketTitle() : string{
        return $this->_ticketTitle;
    }
    public function setTicketTitle(string $title) : void{
        if(!$this->getFormatSetting()->checkTitle($title)){
            throw new PDKInnerArgumentError('title');
        }
        $this->_ticketTitle = $title;
    }
    public function getTicketID() : string{
        return $this->_ticketID;
    }
    public function setTicketID(string $ticketID) : void{
        if(!OAuthTicketFormat::isValidTicketID($ticketID)){
            throw new PDKInnerArgumentError('ticketID');
        }
        $this->_ticketID = $ticketID;
    }
    public function doTicketIDReroll() : void{
        $this->_ticketID = OAuthTicketFormat::generateTicketID();
    }
    public function getClientID() : ?string{
        return $this->_client_id;
    }
    public function setClientID(?string $clientID) : void{
        if(empty($clientID)){
            $clientID = null;
        }
        if($clientID !== null && !APPFormat::isValidAPPID($clientID)){
            throw new PDKInnerArgumentError('clientID');
        }
        $this->_client_id = $clientID;
    }
    public function getMaskID() : ?string{
        return $this->_mask_id;
    }
    public function setMaskID(?string $maskID) : void{
        if(empty($maskID)){
            $maskID = null;
        }
        if($maskID !== null && !MaskIDFormat::isValidMaskID($maskID)){
            throw new PDKInnerArgumentError('maskID');
        }
        $this->_mask_id = $maskID;
    }
    public function getAccessToken() : ?string{
        return $this->_access_token;
    }
    public function setAccessToken(?string $accessToken) : void{
        if(empty($accessToken)){
            $accessToken = null;
        }
        if($accessToken !== null && !APPFormat::isValidAPPAccessToken($accessToken)){
            throw new PDKInnerArgumentError('accessToken');
        }
        $this->_access_token = $accessToken;
    }
    public function getFormatSetting() : OAuthTicketFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatSetting(OAuthTicketFormatSetting $formatSetting) : void{
        $this->_formatSetting = $formatSetting;
    }
}