<?php
namespace InteractivePlus\PDK2021Core\User\Formats;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;

class UserPhoneUtil{
    /**
     * @throws PDKInnerArgumentError
     */
    public static function parsePhone(string $number, ?string $country = null) : PhoneNumber{
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $parsedNumber = null;
        try{
            $parsedNumber = $phoneNumberUtil->parse($number,$country);
        }catch(\libphonenumber\NumberParseException $e){
            throw new PDKInnerArgumentError('number','Phone number passed cannot be parsed');
        }
        return $parsedNumber;
    }
    public static function verifyPhoneNumberObj(\libphonenumber\PhoneNumber $phone) : bool{
        if($phone === NULL){
            return false;
        }
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $parsedNumber = $phone;
        if(!$phoneNumberUtil->isValidNumber($parsedNumber)){
            return false;
        }
        return true;
    }
    public static function outputPhoneNumberNational(PhoneNumber $phoneObj) : string{
        return self::outputPhoneNumber($phoneObj,PhoneNumberFormat::NATIONAL);
    }
    public static function outputPhoneNumberE164(PhoneNumber $phoneObj) : string{
        return self::outputPhoneNumber($phoneObj,PhoneNumberFormat::E164);
    }
    public static function outputPhoneNumberIntl(PhoneNumber $phoneObj) : string{
        return self::outputPhoneNumber($phoneObj,PhoneNumberFormat::INTERNATIONAL);
    }

    public static function outputPhoneNumberRFC3966(PhoneNumber $phoneObj) : string{
        return self::outputPhoneNumber($phoneObj,PhoneNumberFormat::RFC3966);
    }

    /**
     * output the phone number object in a given format
     * @param PhoneNumber $phoneObj the object to be formatted
     * @param int $type the type of the output
     * @return string the formatted output
     * @see \libphonenumber\PhoneNumberFormat
     */
    public static function outputPhoneNumber(PhoneNumber $phoneObj, int $type) : string{
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        return $phoneNumberUtil->format($phoneObj,$type);
    }

}