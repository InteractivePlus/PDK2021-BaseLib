<?php
namespace InteractivePlus\PDK2021Core\APP\Formats;
class APPFormat{
    const APPID_BYTE_LENGTH = 20;
    const APPSECRET_BYTE_LENGTH = 20;
    const AUTH_CODE_BYTE_LENGTH = 16;
    const APPACCESS_TOKEN_BYTE_LENGTH = 16;
    const APPREFRESH_TOKEN_BYTE_LENGTH = 16;
    const CODE_CHALLENGE_S256_HASH_LEN = 64;
    
    public static function getAPPIDByteLength() : int{
        return self::APPID_BYTE_LENGTH;
    }
    public static function getAPPIDStringLength() : int{
        return (self::APPID_BYTE_LENGTH * 2);
    }
    public static function generateAPPID() : string{
        return self::formatAPPID(bin2hex(random_bytes(self::getAPPIDByteLength())));
    }
    public static function isValidAPPID(string $appid) : bool{
        return strlen($appid) === self::getAPPIDStringLength();
    }
    public static function formatAPPID(string $appid) : string{
        return strtolower($appid);
    }
    public static function isAPPIDStringEqual(string $appid1, string $appid2) : bool{
        return self::formatAPPID($appid1) === self::formatAPPID($appid2);
    }

    public static function getAPPSecertByteLength() : int{
        return self::APPSECRET_BYTE_LENGTH;
    }
    public static function getAPPSecertStringLength() : int{
        return (self::APPSECRET_BYTE_LENGTH * 2);
    }
    public static function generateAPPSecert() : string{
        return self::formatAPPSecert(bin2hex(random_bytes(self::getAPPSecertByteLength())));
    }
    public static function isValidAPPSecert(string $secret) : bool{
        return strlen($secret) === self::getAPPSecertStringLength();
    }
    public static function formatAPPSecert(string $secret) : string{
        return strtolower($secret);
    }
    public static function isAPPSecertStringEqual(string $secret1, string $secret2) : bool{
        return self::formatAPPSecert($secret1) === self::formatAPPSecert($secret2);
    }

    public static function getAuthCodeByteLength() : int{
        return self::AUTH_CODE_BYTE_LENGTH;
    }
    public static function getAuthCodeStringLength() : int{
        return (self::AUTH_CODE_BYTE_LENGTH * 2);
    }
    public static function generateAuthCode() : string{
        return self::formatAuthCode(bin2hex(random_bytes(self::getAuthCodeByteLength())));
    }
    public static function isValidAuthCode(string $code) : bool{
        return strlen($code) === self::getAuthCodeStringLength();
    }
    public static function formatAuthCode(string $code) : string{
        return strtolower($code);
    }
    public static function isAuthCodeStringEqual(string $code1, string $code2) : bool{
        return self::formatAuthCode($code1) === self::formatAuthCode($code2);
    }

    public static function getAPPAccessTokenByteLength() : int{
        return self::APPACCESS_TOKEN_BYTE_LENGTH;
    }
    public static function getAPPAccessTokenStringLength() : int{
        return (self::APPACCESS_TOKEN_BYTE_LENGTH * 2);
    }
    public static function generateAPPAccessToken() : string{
        return self::formatAPPAccessToken(bin2hex(random_bytes(self::getAPPAccessTokenByteLength())));
    }
    public static function isValidAPPAccessToken(string $token) : bool{
        return strlen($token) === self::getAPPAccessTokenStringLength();
    }
    public static function formatAPPAccessToken(string $token) : string{
        return strtolower($token);
    }
    public static function isAPPAccessTokenStringEqual(string $token1, string $token2) : bool{
        return self::formatAPPAccessToken($token1) === self::formatAPPAccessToken($token2);
    }

    public static function getAPPRefreshTokenByteLength() : int{
        return self::APPREFRESH_TOKEN_BYTE_LENGTH;
    }
    public static function getAPPRefreshTokenStringLength() : int{
        return (self::APPREFRESH_TOKEN_BYTE_LENGTH * 2);
    }
    public static function generateAPPRefreshToken() : string{
        return self::formatAPPRefreshToken(bin2hex(random_bytes(self::getAPPRefreshTokenByteLength())));
    }
    public static function isValidAPPRefreshToken(string $token) : bool{
        return strlen($token) === self::getAPPRefreshTokenStringLength();
    }
    public static function formatAPPRefreshToken(string $token) : string{
        return strtolower($token);
    }
    public static function isAPPRefreshTokenStringEqual(string $token1, string $token2) : bool{
        return self::formatAPPRefreshToken($token1) === self::formatAPPRefreshToken($token2);
    }

    public static function getChallengeS256StringLength() : int{
        return self::CODE_CHALLENGE_S256_HASH_LEN;
    }
    public static function generateChallengeS256String(string $verifier) : string{
        return self::formatChallengeS256(hash('sha256',$verifier));
    }
    public static function isValidChallengeS256S(string $challenge) : bool{
        return strlen($challenge) === self::getChallengeS256StringLength();
    }
    public static function formatChallengeS256(string $challenge) : string{
        return strtolower($challenge);
    }
    public static function isChallengeS256StringEqual(string $challenge1, string $challenge2) : bool{
        return self::formatChallengeS256($challenge1) === self::formatChallengeS256($challenge2);
    }
}