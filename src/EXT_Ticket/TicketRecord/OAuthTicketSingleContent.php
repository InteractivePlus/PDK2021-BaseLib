<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket\TicketRecord;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use InteractivePlus\PDK2021Core\EXT_Ticket\OAuthTicketFormatSetting;

class OAuthTicketSingleContent{
    private string $_contentStr;
    public bool $isTicketCreatorContent;
    private string $_responderName;
    public int $respondTime;
    public int $lastEditTime;
    private OAuthTicketFormatSetting $_formatSetting;
    public function __construct(
        string $contentStr,
        bool $isTicketCreatorContent,
        string $responderName,
        int $respondTime,
        int $lastEditTime,
        OAuthTicketFormatSetting $formatSetting
    )
    {
        $this->_formatSetting = $formatSetting;
        $this->setContentStr($contentStr);
        $this->isTicketCreatorContent = $isTicketCreatorContent;
        $this->setResponderName($responderName);
        $this->respondTime = $respondTime;
        $this->lastEditTime = $lastEditTime;
    }
    public function getContentStr() : string{
        return $this->_contentStr;
    }
    public function setContentStr(string $contentStr) : void{
        if(!$this->getFormatSetting()->checkContent($contentStr)){
            throw new PDKInnerArgumentError('contentStr');
        }
        $this->_contentStr = $contentStr;
    }

    public function getResponderName() : string{
        return $this->_responderName;
    }

    public function setResponderName(string $name) : void{
        if(!$this->getFormatSetting()->checkResponderName($name)){
            throw new PDKInnerArgumentError('name');
        }
        $this->_responderName = $name;
    }

    public function getFormatSetting() : OAuthTicketFormatSetting{
        return $this->_formatSetting;
    }
    public function setFormatSetting(OAuthTicketFormatSetting $formatSetting) : void{
        $this->_formatSetting = $formatSetting;
    }
}