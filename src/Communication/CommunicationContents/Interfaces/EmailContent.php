<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Interfaces;
class EmailContent{
    private string $_title;
    private string $_content;
    private ?string $_charset = null;
    public function __construct(string $title, string $content, ?string $charset = null){
        $this->_title = $title;
        $this->_content = $content;
        $this->_charset = empty($charset) ? mb_detect_encoding($content) : $charset;
    }
    public function getTitle() : string{
        return $this->_title;
    }
    public function withTitle(string $title) : EmailContent{
        $newObj = clone $this;
        $newObj->_title = $title;
        return $newObj;
    }
    public function getContent() : string{
        return $this->_content;
    }
    public function withContent(string $content) : EmailContent{
        $newObj = clone $this;
        $newObj->_content = $content;
        return $newObj;
    }
    public function getCharset() : string{
        return $this->_charset;
    }
    public function withCharset(?string $charset = null) : EmailContent{
        $newObj = clone $this;
        $newObj->_charset = empty($charset) ? mb_detect_encoding($this->_content) : $charset;
        return $newObj;
    }
}