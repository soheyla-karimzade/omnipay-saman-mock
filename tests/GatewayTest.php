<?php


namespace Omnipay\SamanMock\Tests;

use Omnipay\SamanMock\Gateway;
use Omnipay\SamanMock\TestMessage\AbstractResponse;
use Omnipay\SamanMock\TestMessage\RefundOrderTestModeResponse;
use Omnipay\SamanMock\TestMessage\VerifyOrderTestModeResponse;
use Omnipay\Tests\GatewayTestCase;

/**
 * Class GatewayTest
 * @package Omnipay\ZarinPal\Tests
 */
class GatewayTest extends GatewayTestCase
{

    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var array<string, integer|string|boolean>
     */
    protected $params;


    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setTerminalId('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
        $this->gateway->setReturnUrl('https://www.example.com/return');
        $this->gateway->setTestMode(true);
    }

    public function testPurchaseSuccess(): void
    {

        $paramValue= ['TerminalId'=>'eee','Amount' => '12.00','currency'=>'IRR','ResNum'=>'1qaz@WSX','CellNumber'=>'9120000000'];
        $paramValue['mode']=true;
        $response = $this->gateway->purchase($paramValue)->send();
        $responseData=$response->getData();
        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('2c3c1fefac5a48geb9f9be7e445dd9b24',$responseData['token']);
        self::assertEquals('http://localhost:9005/OnlinePG/SendToken?token=2c3c1fefac5a48geb9f9be7e445dd9b24', $response->getRedirectUrl());
    }

    public function testPurchaseFailure(): void
    {

        $paramValue= ['TerminalId'=>'','Amount' => '12.00','currency'=>'IRR','RedirectUrl'=>'http://mysite.com/receipt','ResNum'=>'1qaz@WSX','CellNumber'=>'9120000000'];
        $paramValue['mode']=false;

        /** @var AbstractResponse $response */
        $response = $this->gateway->purchase($paramValue)->send();

        $responseData=$response->getData();

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertEquals(-1, $responseData['status']);
        self::assertEquals(5, $responseData['errorCode']);
        self::assertEquals(".پارامترهای ارسال شده نامعتبر است", $responseData['errorDesc']);
    }

    public function testCompletePurchaseSuccess(): void
    {
        $param= [
            'RefNum' => 'jJnBmy/IojtTemplUH5ke9ULCGtDtb',
            'TerminalNumber' => 2015,
        ];

        $param['mode']=true;

        $response = $this->gateway->completePurchase($param)->send();

        $responseData=$response->getData();

        self::assertTrue($response->isSuccessful());
        self::assertSame("50", $responseData["TransactionDetail"]['RefNum']);
        self::assertSame(0, $responseData["ResultCode"]);
        self::assertTrue($responseData["Success"]);
    }

    public function testCompletePurchaseFailure(): void
    {

        $param= [
            'RefNum' => '',
            'TerminalNumber' => 2015,
        ];
        $param['mode']=false;

        /** @var VerifyOrderTestModeResponse $response */
        $response = $this->gateway->completePurchase($param)->send();

        $responseData=$response->getData();
        self::assertFalse($response->isSuccessful());
        self::assertNotSame('', $responseData["TransactionDetail"]['RefNum']);
        self::assertEquals(-2, $responseData["ResultCode"]);
    }

    public function testRefundSuccess(): void
    {

        $param= [
            'RefNum' => 'jJnBmy/IojtTemplUH5ke9ULCGtDtb',
            'TerminalNumber' => 2015,
        ];
        $param['mode']=true;

        /** @var RefundOrderTestModeResponse $response */
        $response = $this->gateway->refund($param)->send();

        $responseData=$response->getData();

        self::assertTrue($response->isSuccessful());
        self::assertSame("50", $responseData["TransactionDetail"]['RefNum']);
        self::assertSame(0, $responseData["ResultCode"]);
        self::assertTrue($responseData["Success"]);
    }

    public function testRefundFailure(): void
    {

        $param= [
            'RefNum' => '',
            'TerminalNumber' => 2015,
        ];
        $param['mode']=false;

        /** @var RefundOrderTestModeResponse $response */
        $response = $this->gateway->refund($param)->send();
        $responseData=$response->getData();

        self::assertFalse($response->isSuccessful());
        self::assertNotSame('', $responseData["TransactionDetail"]['RefNum']);
        self::assertEquals(-2, $responseData["ResultCode"]);
    }

}