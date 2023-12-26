<?php


namespace Omnipay\SamanMock\TestMessage;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class CreateOrderResponse
 */
class CreateTokenTestModeResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return (int)$this->getHttpStatus() === 200 && (int)$this->getCode() === 1;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return (int)$this->getCode() === 1 &&
            isset($this->data['token']) &&
            !empty($this->data['token']);
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        /** @var CreateTokenTestModeRequest $request */
        $request = $this->request;

        return sprintf('http://localhost:9005/OnlinePG/SendToken?token=%s', $this->getTransactionReference());
    }


    public function getTransactionReference(){
        return $this->data['token'];
    }
}
