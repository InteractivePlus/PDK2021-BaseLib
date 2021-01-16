<?php
namespace InteractivePlus\PDK2021\User\Formats;
class TokenFormat{
    const TOKEN_BYTE_LENGTH = 16;
    public static function getTokenByteLength() : int{
        return self::TOKEN_BYTE_LENGTH;
    }
    public static function getTokenStringLength() : int{
        return (self::TOKEN_BYTE_LENGTH * 2);
    }
    public static function generateToken() : string{
        return self::formatToken(bin2hex(random_bytes(self::getTokenByteLength())));
    }
    public static function isValidToken(string $code) : bool{
        return strlen($code) === self::getTokenStringLength();
    }
    public static function formatToken(string $code) : string{
        return strtolower($code);
    }
    public static function isTokenStringEqual(string $code1, string $code2) : bool{
        return self::formatToken($code1) === self::formatToken($code2);
    }
}