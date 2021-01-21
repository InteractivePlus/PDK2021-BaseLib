<?php
namespace InteractivePlus\PDK2021Core\Captcha\Implemention;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use InteractivePlus\PDK2021Core\Captcha\Format\CaptchaFormat;
use InteractivePlus\PDK2021Core\Captcha\Interface\PDKCaptcha;
use InteractivePlus\PDK2021Core\Captcha\Interface\PDKCaptchaSystem;

class PDKSimpleCaptchaSystemImpl implements PDKCaptchaSystem{
    private PDKSimpleCaptchaSystemStorage $_storage;

    private int $_imageQuality = 90;
    public int $captchaAvailableDuration = 60 * 5;
    
    public function __construct(int $captchaAvailableDuration, PDKSimpleCaptchaSystemStorage $storage)
    {
        $this->captchaAvailableDuration = $captchaAvailableDuration;
        $this->_storage = $storage;
    }

    public function getImageQuality() : int{
        return $this->_imageQuality;
    }

    public function setImageQuality(int $quality) : void{
        if($quality < 0){
            $quality = 0;
        }else if($quality > 100){
            $quality = 100;
        }
        $this->_imageQuality = $quality;
    }
    public function getStorage() : PDKSimpleCaptchaSystemStorage{
        return $this->_storage;
    }
    public function generateAndSaveCaptchaToStorage($passedInCaptchaParam = null) : PDKCaptcha{
        $requestWidth = (isset($passedInCaptchaParam['width']) && is_numeric($passedInCaptchaParam['height'])) ? (int) $passedInCaptchaParam['width'] : 150;
        $requestHeight = (isset($passedInCaptchaParam['height']) && is_numeric($passedInCaptchaParam['height'])) ? (int) $passedInCaptchaParam['height'] : 40;
        
        $ctime = time();
        $expireTime = $ctime + $this->captchaAvailableDuration;

        $phraseBuilder = new PhraseBuilder($this->_storage->getPhraseLen());
        $captchaBuilder = new CaptchaBuilder(null,$phraseBuilder);

        $captchaBuilder->buildAgainstOCR($requestWidth,$requestHeight,null,null);
        $captchaID = CaptchaFormat::generateCaptchaID();
        while($this->_storage->checkCaptchaIDExist($captchaID)){
            $captchaID = CaptchaFormat::generateCaptchaID();
        }

        $captchaJpegData = $captchaBuilder->get($this->_imageQuality);
        $captchaBase64Data = base64_encode($captchaJpegData);
        $captchaPhrase = $captchaBuilder->getPhrase();

        $captcha = new PDKCaptcha(
            $captchaID,
            array(
                'width' => $requestWidth,
                'height'=> $requestHeight,
                'jpegBase64' => $captchaBase64Data,
                'phraseLen' => $this->_storage->getPhraseLen()
            ),
            $expireTime
        );
        
        $this->_storage->saveCaptchaToDatabase($captchaID,$captchaPhrase,$ctime,$expireTime,$requestWidth,$requestHeight,false,false);
        return $captcha;
    }
    public function checkCaptchaAvailable(string $captchaID) : bool{
        return $this->_storage->checkCaptchaAvailable($captchaID,time());
    }
    public function checkAndUseCpatcha(string $captchaID) : bool{
        if($this->_storage->checkCaptchaAvailable($captchaID,time())){
            $this->_storage->useCpatcha($captchaID);
            return true;
        }else{
            return false;
        }
    }
    public function trySubmitCaptchaPhrase(string $captchaID, string $phrase) : bool{
        return $this->_storage->trySubmitCaptchaPhrase($captchaID,$phrase);
    }
}