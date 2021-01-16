<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;

use InteractivePlus\PDK2021Core\Communication\CommunicationMethods\CommunicationMethod;

class VeriCodeProperty{
    private bool $m_canCheckBeforeUse = false;
    private bool $m_hasActionAssociated = false;
    private ?array $associatedParam = null;
    private ?array $requiredParam = null;
    private bool $m_CheckIPAddr = false;
    private int $allowedCommunicationMethods = CommunicationMethod::ALL;
    public function __construct(
        bool $canCheckBeforeUse,
        bool $hasActionAssociated,
        int $allowedMethods = CommunicationMethod::ALL,
        bool $checkIPAddr = false,
        ?array $requiredParamNames = null,
        ?array $otherAssociatedParamNames = null
    )
    {
        $this->m_canCheckBeforeUse = $canCheckBeforeUse;
        $this->m_hasActionAssociated = $hasActionAssociated;
        $this->allowedCommunicationMethods = $allowedMethods;
        $this->m_CheckIPAddr = $checkIPAddr;
        $this->requiredParam = $requiredParamNames;
        $this->associatedParam = $otherAssociatedParamNames;
    }

    public function canCheckBeforeUse() : bool{
        return $this->m_canCheckBeforeUse;
    }
    public function hasActionAssociated() : bool{
        return $this->m_hasActionAssociated;
    }
    
    public function getRequiredParamNames() : ?array{
        return $this->requiredParam;
    }

    public function getAssociatedParamNames() : ?array{
        return $this->associatedParam;
    }

    public function getAllowedCommunicationMethods() : int{
        return $this->allowedCommunicationMethods;
    }

    public function needToCheckIPAddr() : bool{
        return $this->m_CheckIPAddr;
    }

    public function isParamNameAssociatedOrRequired(string $name) : bool{
        return in_array($name,$this->associatedParam,true) || in_array($name,$this->requiredParam,true);
    }
}