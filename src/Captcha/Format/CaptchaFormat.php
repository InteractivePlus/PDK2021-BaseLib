<?php
namespace InteractivePlus\PDK2021Core\Captcha\Format;
class CaptchaFormat{
    const CAPTCHA_ID_BYTE_LENGTH = 16;
    public static function getCaptchaIDByteLength() : int{
        return self::CAPTCHA_ID_BYTE_LENGTH;
    }
    public static function getCaptchaIDStringLength() : int{
        return (self::CAPTCHA_ID_BYTE_LENGTH * 2);
    }
    public static function generateCaptchaID() : string{
        return self::formatCaptchaID(bin2hex(random_bytes(self::getCaptchaIDByteLength())));
    }
    public static function isValidCaptchaID(string $id) : bool{
        return strlen($id) === self::getCaptchaIDStringLength();
    }
    public static function formatCaptchaID(string $id) : string{
        return strtolower($id);
    }
    public static function isCaptchaIDEqual(string $id1, string $id2) : bool{
        return self::formatCaptchaID($id1) === self::formatCaptchaID($id2);
    }
}