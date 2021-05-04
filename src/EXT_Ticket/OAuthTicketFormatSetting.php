<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket;
interface OAuthTicketFormatSetting{
    public function getTitleMinLen() : int;
    public function getTitleMaxLen() : int;
    public function checkTitle(string $title) : bool;
    public function getContentMinLen() : int;
    public function getContentMaxLen() : int;
    public function checkContent(string $content) : bool;
    public function getResponderNameMinLen() : int;
    public function getResponderNameMaxLen() : int;
    public function checkResponderName(string $responderName) : bool;
}