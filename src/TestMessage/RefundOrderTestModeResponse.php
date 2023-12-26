<?php

namespace Omnipay\SamanMock\TestMessage;

/**
 * Class InquiryOrderResponse
 */
class RefundOrderTestModeResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return $this->getHttpStatus() === 200 && (int)$this->getResultCode() == 0;
    }
}
