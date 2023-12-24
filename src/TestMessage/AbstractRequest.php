<?php



namespace Omnipay\Saman\TestMessage;

use Exception;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Saman\Message\AbstractResponse;
use RuntimeException;
use Omnipay\Common\Exception\InvalidRequestException;
use stdClass;

///**
// * Class AbstractRequest
// */
//function json_response(int $int, array $array)
//{
//
//}

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected string $liveEndpoint = 'http://localhost:9005/src/TestMessage';
//    protected string $liveEndpoint = '';

    /**
     * @return string
     */
    abstract protected function getHttpMethod();

    /**
     * @param string $endpoint
     * @return string
     */
    abstract protected function createUri(string $endpoint);

    /**
     * @param array $data
     * @return AbstractResponse
     */
    abstract protected function createResponse(array $data);

    /**
     * @param bool $value
     * @return self
     */
    public function setMode($value)
    {
        return $this->setParameter('mode', $value);
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
     * @return bool
     */
    public function getMode(): bool
    {
        return $this->getParameter('mode');
    }


    public function setOrderId(int $value){
        return $this->setParameter('orderId', $value);
    }
    public function getOrderId(){
        return $this->getParameter('orderId');
    }

    public function getTerminalId(){
        return $this->getParameter('TerminalId');
    }

    /**
     * @return bool
     */
    public function getAutoVerify(): bool
    {
        return (bool)$this->getParameter('autoVerify');
    }

    /**
     * @return string
     * @throws InvalidRequestException
     */
    public function getAmount(): string
    {
        $currency = $this->getCurrency();

        // a little hack to prevent error because of non-standard currency code!
        // only "IRR" is a standard iso code
        if ($currency !== 'IRR') {
            $this->setCurrency('IRR');
            $value = parent::getAmount();
            $this->setCurrency($currency);
        } else {
            $value = parent::getAmount();
        }

        $value = $value ?: $this->httpRequest->query->get('Amount');
        return (string)$value;
    }

    /**
     * @return string|null
     */
    public function getCustomerPhone(): ?string
    {
        return $this->getParameter('CellNumber');
    }

    /**
     * Get the request return URL.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->getParameter('RedirectUrl');
    }

    /**
     * @return string|null
     */
    public function getPayerName(): ?string
    {
        return $this->getParameter('payerName');
    }

    /**
     * @return string|null
     */
    public function getPayerDesc(): ?string
    {
        return $this->getParameter('payerName');
    }

    /**
     * @return string|null
     */
    public function getAllowedCard(): ?string
    {
        return $this->getParameter('allowedCard');
    }

    /**
     * @param string $value
     * @return self
     */
    public function setTerminalId(string $value): self
    {
        return $this->setParameter('TerminalId', $value);
    }

    /**
     * @param string $value
     * @return self
     */
    public function setAmount($value): self
    {
        return $this->setParameter('Amount', $value);
    }


    /**
     * @param string $value
     * @return self
     */
    public function setReturnUrl($value): self
    {
        return $this->setParameter('RedirectUrl', $value);
    }


    /**
     * @param string $value
     * @return self
     */
    public function setApiKey(string $value): self
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @param bool $autoVerify
     * @return self
     */
    public function setAutoVerify(bool $autoVerify): self
    {
        return $this->setParameter('autoVerify', $autoVerify);
    }

    /**
     * @param string $customerPhone
     * @return self
     */
    public function setCustomerPhone(string $customerPhone): self
    {
        return $this->setParameter('customerPhone', $customerPhone);
    }

    /**
     * @param mixed $meta
     * @return self
     */
    public function setMeta(mixed $meta): self
    {
        return $this->setParameter('meta', json_encode($meta));
    }

    /**
     * @param string $payerName
     * @return self
     */
    public function setPayerName(string $payerName): self
    {
        return $this->setParameter('payerName', $payerName);
    }

    /**
     * @param string $payerDesc
     * @return self
     */
    public function setPayerDesc(string $payerDesc): self
    {
        return $this->setParameter('payerDesc', $payerDesc);
    }

    /**
     * @param string $allowedCard
     * @return self
     */
    public function setAllowedCard(string $allowedCard): self
    {
        return $this->setParameter('allowedCard', $allowedCard);
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
//        if ($this->getTestMode()) {
//            throw new \InvalidArgumentException('Saman payment gateway does not support test mode.');
//        }
        return $this->liveEndpoint;
    }


    public function setRefNum($value){
        return $this->setParameter('RefNum', $value);
    }

    public function getRefNum(){
        return $this->getParameter('RefNum');
    }

    public function setTerminalNumber($value){
        return $this->setParameter('TerminalNumber', $value);
    }
    public function getTerminalNumber(){
        return $this->getParameter('TerminalNumber');
    }


    function json_response($code = 200, $message = null)
    {

        ob_start();
        // clear the old headers
//        header_remove();
        // set the/ actual code
        http_response_code($code);
        // set the header to make sure cache is forced
//        header("Cache-Control:no-transform,public,max-age=300,s-maxage=900");
//         treat this as json
//        header('Content-Type:application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        // ok, validation error, or failure
//        header('Status:'.$status[$code]);
        ob_clean();


//        ob_end_clean();
        // return the encoded json
        return json_encode(array(
            'status' => $code < 300, // success or not?
            'message' => $message
        ));
    }



    public function sendData($data)
    {

        $url=$this->createUri($this->getEndpoint());

        try {

            $body = json_encode($data);
            if ($body === false) {
                throw new RuntimeException('Err in access/refresh token.');
            }

            $url=$this->createUri($this->getEndpoint());
            $filename = $url;
            $data = file_get_contents($filename); //data read from json file
//            $json=json_decode($data);

//            $result= $this->json_response(200, $json);
//            $json = $httpResponse->getBody()->getContents();

            $result = !empty($data) ? json_decode($data, true) : [];
            $result['httpStatus'] = 200;
            return $this->response = $this->createResponse($result);
        }
        catch (Exception $e){
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }

    }

    public function successResponse(){
        $myObj = new stdClass();
        $myObj->status = 1;
        $myObj->token = "2c3c1fefac5a48geb9f9be7e445dd9b2";
        /** @var object $data */
        $data = json_encode($myObj);
        return $data;
    }


}
