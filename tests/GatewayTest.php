<?php


namespace Omnipay\Saman\Tests;

use Omnipay\Saman\Gateway;
use Omnipay\Saman\Message\AbstractResponse;
use Omnipay\Saman\Message\RefundOrderTestModeResponse;
use Omnipay\Saman\Message\VerifyOrderTestModeResponse;
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

        $this->gateway->setMode(true);
        $paramValue= ['TerminalId'=>'eee','Amount' => '12.00','currency'=>'IRR','ResNum'=>'1qaz@WSX','CellNumber'=>'9120000000'];
        $response = $this->gateway->purchase($paramValue)->send();
        $responseData=$response->getData();
        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isRedirect());
//        self::assertEquals('2c3c1fefac5a48geb9f9be7e445dd9b24',$responseData['token']);
//        self::assertEquals('http://localhost:9005/OnlinePG/SendToken?token=2c3c1fefac5a48geb9f9be7e445dd9b24', $response->getRedirectUrl());
    }




//    public function testPurchaseFailure(): void
//    {
//
//        $this->gateway->setMode(false);
//        $this->setMockHttpResponse('PurchaseFailure.txt');
//
//        $paramValue= ['TerminalId'=>'','Amount' => '12.00','currency'=>'IRR','RedirectUrl'=>'http://mysite.com/receipt','ResNum'=>'1qaz@WSX','CellNumber'=>'9120000000'];
//        /** @var AbstractResponse $response */
//        $response = $this->gateway->purchase($paramValue)->send();
//var_dump($response);
//echo '----------------------';
//var_dump($response->getData());
//die;
//        $responseData=$response->getData();
//        self::assertFalse($response->isSuccessful());
//        self::assertFalse($response->isRedirect());
//        self::assertEquals(-1, $responseData['status']);
//        self::assertEquals(5, $responseData['errorCode']);
//        self::assertEquals(".پارامترهای ارسال شده نامعتبر است", $responseData['errorDesc']);
//    }
//
//
//    public function testCompletePurchaseSuccess(): void
//    {
//        $this->setMockHttpResponse('PurchaseCompleteSuccess.txt');
//
//        $param= [
//            'RefNum' => 'jJnBmy/IojtTemplUH5ke9ULCGtDtb',
//            'TerminalNumber' => 2015,
//        ];
//
//        $response = $this->gateway->completePurchase($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertTrue($response->isSuccessful());
//        self::assertSame("50", $responseData["TransactionDetail"]['RefNum']);
//        self::assertSame(0, $responseData["ResultCode"]);
//        self::assertTrue($responseData["Success"]);
//    }
//
//
//
//    public function testCompletePurchaseFailure(): void
//    {
//        $this->setMockHttpResponse('PurchaseCompleteFailure.txt');
//
//        $param= [
//            'RefNum' => '',
//            'TerminalNumber' => 2015,
//        ];
//
//        /** @var VerifyOrderTestModeResponse $response */
//        $response = $this->gateway->completePurchase($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertFalse($response->isSuccessful());
//        self::assertNotSame('', $responseData["TransactionDetail"]['RefNum']);
//        self::assertEquals(-2, $responseData["ResultCode"]);
//    }
//
//
//
//    public function testRefundSuccess(): void
//    {
//        $this->setMockHttpResponse('PurchaseCompleteSuccess.txt');
//
//        $param= [
//            'RefNum' => 'jJnBmy/IojtTemplUH5ke9ULCGtDtb',
//            'TerminalNumber' => 2015,
//        ];
//
//        /** @var RefundOrderTestModeResponse $response */
//        $response = $this->gateway->refund($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertTrue($response->isSuccessful());
//        self::assertSame("50", $responseData["TransactionDetail"]['RefNum']);
//        self::assertSame(0, $responseData["ResultCode"]);
//        self::assertTrue($responseData["Success"]);
//    }
//
//
//    public function testRefundFailure(): void
//    {
//        $this->setMockHttpResponse('PurchaseCompleteFailure.txt');
//
//        $param= [
//            'RefNum' => '',
//            'TerminalNumber' => 2015,
//        ];
//
//        /** @var RefundOrderTestModeResponse $response */
//        $response = $this->gateway->refund($param)->send();
//        $responseData=$response->getData();
//
//        self::assertFalse($response->isSuccessful());
//        self::assertNotSame('', $responseData["TransactionDetail"]['RefNum']);
//        self::assertEquals(-2, $responseData["ResultCode"]);
//    }

}