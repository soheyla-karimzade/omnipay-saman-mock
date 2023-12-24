<?php

namespace Omnipay\Saman\TestMessage;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class CreateTokenRequest
 */
class CreateTokenTestModeRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData():array
    {
        // Validate required parameters before return data
        $this->validate('TerminalId', 'Amount', 'currency', 'RedirectUrl');

        return [
            'action' =>"token",
            'TerminalId' => $this->getTerminalId(),
            'Amount' => $this->getAmount(),
            'ResNum' => $this->getOrderId(),
            'RedirectUrl' => $this->getReturnUrl(),
            'CellNumber' => $this->getCustomerPhone(),
            'currency' => $this->getCurrency(),
            'payer_name' => $this->getPayerName(),
            'payer_desc' => $this->getPayerDesc(),
            'auto_verify' => $this->getAutoVerify(),
            'allowed_card' => $this->getAllowedCard(),
        ];
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function createUri(string $endpoint)
    {
        if(!$this->getMode())
            return $endpoint .'/PaymentTokenFailure.json';

        return $endpoint .'/PaymentToken.json';

    }

    /**
     * @param array $data
     * @return CreateTokenTestModeResponse
     */
    protected function createResponse(array $data)
    {
        return new CreateTokenTestModeResponse($this, $data);
    }
}
