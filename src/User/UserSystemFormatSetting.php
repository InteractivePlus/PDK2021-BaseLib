<?php
namespace InteractivePlus\PDK2021Core\User;
interface UserSystemFormatSetting{
    public function getUserNameMinLen() : int;
    public function getUserNameMaxLen() : int;
    public function checkUserName(string $username) : bool;
    public function getNickNameMinLen() : int;
    public function getNickNameMaxLen() : int;
    public function checkNickName(?string $nickname) : bool;
    public function getSignatureMinLen() : int;
    public function getSignatureMaxLen() : int;
    public function checkSignature(?string $signature) : bool;
    public function getPasswordMinLen() : int;
    public function getPasswordMaxLen() : int;
    public function checkPassword(string $password) : bool;
    public function getEmailAddrMinLen() : int;
    public function setEmailAddrMaxLen() : int;
    public function checkEmailAddr(string $emailAddr) : bool;
    public function getHashEncryptionSalt() : ?string;
}