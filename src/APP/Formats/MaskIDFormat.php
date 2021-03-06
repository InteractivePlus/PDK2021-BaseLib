<?php
namespace InteractivePlus\PDK2021Core\APP\Formats;
class MaskIDFormat{
    const MaskID_BYTE_LENGTH = 16;
    const MaskID_DISPLAY_NAME_LENGTH = 20;
    public static function getMaskIDByteLength() : int{
        return self::MaskID_BYTE_LENGTH;
    }
    public static function getMaskIDStringLength() : int{
        return (self::MaskID_BYTE_LENGTH * 2);
    }
    public static function generateMaskID() : string{
        return self::formatMaskID(bin2hex(random_bytes(self::getMaskIDByteLength())));
    }
    public static function isValidMaskID(string $MaskID) : bool{
        return strlen($MaskID) === self::getMaskIDStringLength();
    }
    public static function formatMaskID(string $MaskID) : string{
        return strtolower($MaskID);
    }
    public static function isMaskIDStringEqual(string $MaskID1, string $MaskID2) : bool{
        return self::formatMaskID($MaskID1) === self::formatMaskID($MaskID2);
    }
    public static function getMaskIDDispalyNameLength() : int{
        return self::MaskID_DISPLAY_NAME_LENGTH;
    }
    public static function isValidMaskIDDisplayName(string $displayName) : bool{
        return strlen($displayName) <= self::getMaskIDDispalyNameLength();
    }
}