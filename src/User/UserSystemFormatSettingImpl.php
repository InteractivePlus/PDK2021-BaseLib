<?php
namespace InteractivePlus\PDK2021Core\User;
class UserSystemFormatSettingImpl implements UserSystemFormatSetting{
    private int $_usernameMin;
    private int $_usernameMax;
    private int $_nicknameMin;
    private int $_nicknameMax;
    private int $_signatureMin;
    private int $_signatureMax;
    private int $_passwordMin;
    private int $_passwordMax;
    private int $_emailMin;
    private int $_emailMax;
    private ?string $hashEncryptionSalt;
    public function __construct(
        int $usernameMin,
        int $usernameMax,
        int $nicknameMin,
        int $nicknameMax,
        int $signatureMin,
        int $signatureMax,
        int $passwordMin,
        int $passwordMax,
        int $emailMin,
        int $emailMax,
        ?string $hashEncryptionSalt = null
    )
    {
        $this->_usernameMin = $usernameMin;
        $this->_usernameMax = $usernameMax;
        $this->_nicknameMin = $nicknameMin;
        $this->_nicknameMax = $nicknameMax;
        $this->_signatureMin = $signatureMin;
        $this->_signatureMax = $signatureMax;
        $this->_passwordMin = $passwordMin;
        $this->_passwordMax = $passwordMax;
        $this->_emailMin = $emailMin;
        $this->_emailMax = $emailMax;
        $this->hashEncryptionSalt = empty($hashEncryptionSalt) ? null : $hashEncryptionSalt;
    }
    public function getUserNameMinLen() : int{
        return $this->_usernameMin;
    }
    public function getUserNameMaxLen() : int{
        return $this->_usernameMax;
    }
    public function checkUserName(string $username) : bool{
        return strlen($username) >= $this->getUserNameMinLen() && strlen($username) <= $this->getUserNameMaxLen();
    }
    public function getNickNameMinLen() : int{
        return $this->_nicknameMin;
    }
    public function getNickNameMaxLen() : int{
        return $this->_nicknameMax;
    }
    public function checkNickName(?string $nickname) : bool{
        return strlen($nickname) >= $this->getNickNameMinLen() && strlen($nickname) <= $this->getNickNameMaxLen();
    }
    public function getSignatureMinLen() : int{
        return $this->_signatureMin;
    }
    public function getSignatureMaxLen() : int{
        return $this->_signatureMax;
    }
    public function checkSignature(?string $signature) : bool{
        return strlen($signature) >= $this->getSignatureMinLen() && strlen($signature) <= $this->getSignatureMaxLen();
    }
    public function getPasswordMinLen() : int{
        return $this->_passwordMin;
    }
    public function getPasswordMaxLen() : int{
        return $this->_passwordMax;
    }
    public function checkPassword(string $password) : bool{
        return strlen($password) >= $this->getPasswordMinLen() && strlen($password) <= $this->getPasswordMaxLen();
    }
    public function getEmailAddrMinLen() : int{
        return $this->_emailMin;
    }
    public function getEmailAddrMaxLen() : int{
        return $this->_emailMax;
    }
    public function checkEmailAddr(string $emailAddr) : bool{
        return strlen($emailAddr) >= $this->getEmailAddrMinLen() && strlen($emailAddr) <= $this->getEmailAddrMaxLen() && filter_var($emailAddr,FILTER_VALIDATE_EMAIL);
    }
    public function getHashEncryptionSalt() : ?string{
        return $this->hashEncryptionSalt;
    }
}