<?php
namespace InteractivePlus\PDK2021\Communication\CommunicationContents;
class EmailContent{
    private string $_title;
    private string $_content;
    public function __construct(string $title, string $content){
        $this->_title = $title;
        $this->_content = $content;
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
}