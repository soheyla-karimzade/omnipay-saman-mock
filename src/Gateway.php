<?php

namespace Omnipay\Saman;

use Omnipay\Common\AbstractGateway;
use Omnipay\Saman\TestMessage\RefundOrderTestModeRequest;
use Omnipay\Saman\TestMessage\VerifyOrderTestModeRequest;
use Omnipay\Saman\TestMessage\CreateTokenTestModeRequest;

class Gateway extends  AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName(): string
    {
        return 'Saman';
    }

    /**
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'testMode' => false,
            'TerminalId' => '',
            'returnUrl' => '',
            'mode'=>true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);
        return $this;
    }

    /**
     * Sets the test mode of the request.
     *
     * @param boolean $value True for test mode on.
     * @return $this
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }


    /**
     * @return string
     */
    public function getReturnUrl(): ?string
    {
        return $this->getParameter('returnUrl');
    }


    /**
     * @param bool $value
     * @return self
     */
    public function setMode(bool $value): self
    {
        return $this->setParameter('mode', $value);
    }

    /**
     * @return bool
     */
    public function getMode(): bool
    {
        return $this->getParameter('mode');
    }

    /**
     * @param string $value
     * @return self
     */
    public function setReturnUrl(string $value): self
    {
        return $this->setParameter('returnUrl', $value);
    }


    public function setTerminalId(string $value){
        return $this->setParameter('TerminalId', $value);
    }

    public function getTerminalId(){
        return $this->getParameter('TerminalId');
    }


    /**
     * @inheritDoc
     */
    public function purchase(array $options = [])
    {
//        if($this->getTestMode()===false)
//            return $this->createRequest(CreateTokenRequest::class, $options);
//        if ($this->getTestMode()===true)
            return $this->createRequest(CreateTokenTestModeRequest::class, $options);
    }

    /**
     * @inheritDoc
     */
    public function completePurchase(array $options = [])
    {
//        if($this->getTestMode()===false)
//            return $this->createRequest(VerifyOrderRequest::class, $options);
//        if ($this->getTestMode()===true)
            return $this->createRequest(VerifyOrderTestModeRequest::class, $options);
    }

    /**
     * @inheritDoc
     */
    public function refund(array $options = [])
    {
//        if($this->getTestMode()===false)
//            return $this->createRequest(RefundOrderTestModeRequest::class, $options);
//        if ($this->getTestMode()===true)
            return $this->createRequest(RefundOrderTestModeRequest::class, $options);
    }



    public function failureResponse(){

    }
}