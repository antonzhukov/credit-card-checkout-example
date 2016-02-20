<?php
/**
 * @author zhukov
 */

namespace ApplicationTest\Model\Payment\PaymentService;

use Application\Model\Payment\PaymentService\EuroPaymentGroup;
use Application\ValueObject\CreditCardPayment;
use Application\ValueObject\PaymentServiceResponse;

class EuroPaymentGroupTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = [
            'url' => 'http://test',
            'app_name' => 'test_merchant',
            'secret_key' => 'f11t4kT3Go2Mz7U8',
        ];
    }

    /**
     * @param CreditCardPayment      $payment
     * @param string                 $json
     * @param PaymentServiceResponse $expectedResponse
     * @dataProvider providerSendRequest
     */
    public function testSendRequest(CreditCardPayment $payment, $json, PaymentServiceResponse $expectedResponse)
    {
        $service = $this->getMockBuilder('Application\Model\Payment\PaymentService\EuroPaymentGroup')
            ->setConstructorArgs(array($this->config))
            ->setMethods(['sendRequest'])
            ->getMock();
        $service->expects($this->any())
            ->method('sendRequest')
            ->willReturn($json);

        /** @var EuroPaymentGroup $service */
        $responseObject = $service->processCreditCardPayment($payment);

        $this->assertEquals($expectedResponse->result, $responseObject->result);
        $this->assertEquals($expectedResponse->message, $responseObject->message);

    }

    /**
     * @return array
     */
    public function providerSendRequest()
    {
        $payment = new CreditCardPayment(
            'Anton',
            'Zhukov',
            100,
            'USD',
            '1111-0000-1000-0000',
            123,
            '09',
            '2011'
        );
        return [
            [
                $payment,
                ['result' => 'OK', 'resultCode' => 1, 'id' => 123],
                new PaymentServiceResponse(true, '')
            ],
            [
                $payment,
                ['result' => 'DECLINE', 'resultCode' => 555, 'message' => 'Amount exceed'],
                new PaymentServiceResponse(false, 'Amount exceed')
            ],
        ];
    }
}
