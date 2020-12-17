<?php
namespace InteractivePlus\PDK2021\User\Login;
class LoginFailedReasons{
    const EMAIL_NOT_VERIFIED = 1;
    const PHONE_NOT_VERIFIED = 2;
    const EITHER_NOT_VERIFIED = 3;
    const ACCOUNT_FROZEN = 4;
    const UNKNOWN = 5;
}