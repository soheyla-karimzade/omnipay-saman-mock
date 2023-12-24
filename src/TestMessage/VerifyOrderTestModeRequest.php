<?php

namespace Omnipay\Saman\TestMessage;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class VerifyOrderRequest
 */
class VerifyOrderTestModeRequest extends AbstractRequest
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
        $this->validate('RefNum','TerminalNumber');

        return [
            'RefNum' => $this->getRefNum(),
            'TerminalNumber' => $this->getTerminalNumber(),
        ];
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function createUri(string $endpoint)
    {
        if(!$this->getMode())
            return 'VerifyOrderFailure.json';
        return 'VerifyOrder.json';
    }

    /**
     * @param array $data
     * @return VerifyOrderTestModeResponse
     */
    protected function createResponse(array $data)
    {
        return new VerifyOrderTestModeResponse($this, $data);
    }
}
