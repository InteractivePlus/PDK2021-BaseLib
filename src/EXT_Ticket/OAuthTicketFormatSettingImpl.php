<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket;
class OAuthTicketFormatSettingImpl implements OAuthTicketFormatSetting{
    private int $_titleMinLen;
    private int $_titleMaxLen;
    private int $_contentMinLen;
    private int $_contentMaxLen;
    private int $_responderNameMinLen;
    private int $_responderNameMaxLen;
    public function __construct(
        int $titleMinLen,
        int $titleMaxLen,
        int $contentMinLen,
        int $contentMaxLen,
        int $responderNameMinLen,
        int $responderNameMaxLen
    )
    {
        $this->_titleMinLen = $titleMinLen;
        $this->_titleMaxLen = $titleMaxLen;
        $this->_contentMinLen = $contentMinLen;
        $this->_contentMaxLen = $contentMaxLen;
        $this->_responderNameMinLen = $responderNameMinLen;
        $this->_responderNameMaxLen = $responderNameMaxLen;
    }
    public function getTitleMinLen() : int{
        return $this->_titleMinLen;
    }
    public function getTitleMaxLen() : int{
        return $this->_titleMaxLen;
    }
    public function checkTitle(string $title) : bool{
        $lenTitle = strlen($title);
        return ($lenTitle >= $this->getTitleMinLen() && $lenTitle <= $this->getTitleMaxLen());
    }
    public function getContentMinLen() : int{
        return $this->_contentMinLen;
    }
    public function getContentMaxLen() : int{
        return $this->_contentMaxLen;
    }
    public function checkContent(string $content) : bool{
        $contentLen = strlen($content);
        return ($contentLen >= $this->getContentMinLen() && $contentLen <= $this->getContentMaxLen());
    }
    public function getResponderNameMinLen() : int{
        return $this->_responderNameMinLen;
    }
    public function getResponderNameMaxLen() : int{
        return $this->_responderNameMaxLen;
    }
    public function checkResponderName(string $responderName) : bool{
        $responderNameLen = strlen($responderName);
        return ($responderNameLen >= $this->getResponderNameMinLen() && $responderNameLen <= $this->getResponderNameMaxLen());
    }
}