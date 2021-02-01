<?php
namespace InteractivePlus\PDK2021Core\APP\AuthCode;
class AuthCodeChallengeType{
    const NO_CHALLENGE = 0;
    const PLAIN = 1;
    const SHA256 = 2;
    public static function isValidChallengeType(int $type) : bool{
        return $type >= 1 && $type <= 2;
    }
    public static function fixChallengeType(int $type) : int{
        if(!self::isValidChallengeType($type)){
            return self::NO_CHALLENGE;
        }else{
            return $type;
        }
    }
    public static function parseChallengeType(string $challengeType) : int{
        $challengeType = strtoupper($challengeType);
        if($challengeType === 'S256' || $challengeType === 'SHA256' || $challengeType === 'SHA-256'){
            return self::SHA256;
        }else if($challengeType === 'PLAIN'){
            return self::PLAIN;
        }else{
            return self::NO_CHALLENGE;
        }
    }
}