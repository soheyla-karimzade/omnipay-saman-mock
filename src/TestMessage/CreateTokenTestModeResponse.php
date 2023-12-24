<?php


namespace Omnipay\Saman\TestMessage;

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
//echo (int)$this->getHttpStatus() ;
//echo (int)$this->getCode();
        return (int)$this->getHttpStatus() === 200 && (int)$this->getCode() === 1;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {

//        die($this->getCode() );
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

//        echo sprintf('http://localhost:9005/OnlinePG/SendToken?token=%s', $request->getEndpoint(), $this->getTransactionReference());
        return sprintf('http://localhost:9005/OnlinePG/SendToken?token=%s', $this->getTransactionReference());
    }


    public function getTransactionReference(){
        return $this->data['token'];
    }
}
