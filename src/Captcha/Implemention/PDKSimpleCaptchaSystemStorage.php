<?php
namespace InteractivePlus\PDK2021Core\Captcha\Implemention;
interface PDKSimpleCaptchaSystemStorage{
    public function saveCaptchaToDatabase(string $captchaID, string $phrase, int $issued_time, int $expire_time, int $width, int $height, bool $phrasePassed = false, bool $used = false);
    public function checkCaptchaAvailable(string $captchaID, int $currentTime) : bool;
    public function useCpatcha(string $captchaID) : void;
    public function checkCaptchaIDExist(string $captchaID) : bool;
    public function trySubmitCaptchaPhrase(string $captchaID, string $phrase) : bool;
}