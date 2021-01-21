<?php
namespace InteractivePlus\PDK2021Core\Captcha\Interface;
interface PDKCaptchaSystem{
    public function generateAndSaveCaptchaToStorage($passedInCaptchaParam = null) : PDKCaptcha;
    public function checkCaptchaAvailable(string $captchaID) : bool;
    public function trySubmitCaptchaPhrase(string $captchaID, string $phrase) : bool;
    public function checkAndUseCpatcha(string $captchaID) : bool;
}