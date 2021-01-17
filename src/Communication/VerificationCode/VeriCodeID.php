<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;
use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\CommunicationMethod;

class VeriCodeID{
    private int $veriCodeID = 0;
    private VeriCodeProperty $veriCodeProperty = null;
    public function __construct(int $veriCodeID, VeriCodeProperty $veriCodeProperty){
        $this->veriCodeID = $veriCodeID;
        $this->veriCodeProperty = $veriCodeProperty;
    }
    public function getVeriCodeID() : int{
        return $this->veriCodeID;
    }
    public function getProperty() : VeriCodeProperty{
        return $this->veriCodeProperty;
    }
    
}