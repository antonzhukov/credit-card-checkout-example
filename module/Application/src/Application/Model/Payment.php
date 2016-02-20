<?php
/**
 * @author zhukov
 */

namespace Application\Model;


use Application\Model\Payment\Dao;
use Application\Model\Payment\PaymentService;
use Application\ValueObject\CreditCardPayment;
use Application\Exception\BadResponseException;
use Application\ValueObject\PaymentServiceResponse;

/**
 * Class Payment
 * @package Application\Model
 */
class Payment
{
    /**
     * @var Dao
     */
    protected $dao;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * Payment constructor.
     * @param Dao $dao
     * @param PaymentService $paymentService
     */
    public function __construct(Dao $dao, PaymentService $paymentService)
    {
        $this->dao = $dao;
        $this->paymentService = $paymentService;
    }

    /**
     * @param int    $userId
     * @param string $firstName
     * @param string $lastName
     * @param float  $amount
     * @param string $currency
     * @param string $cardNumber
     * @param int    $cvv
     * @param string $expireMonth
     * @param string $expireYear
     * @return PaymentServiceResponse
     */
    public function processUserPayment(
        $userId,
        $firstName,
        $lastName,
        $amount,
        $currency,
        $cardNumber,
        $cvv,
        $expireMonth,
        $expireYear
    ) {
        $payment = new CreditCardPayment(
            $firstName,
            $lastName,
            $amount,
            $currency,
            $cardNumber,
            $cvv,
            $expireMonth,
            $expireYear
        );

        try {
            $response = $this->paymentService->processCreditCardPayment($userId, $payment);
        } catch (BadResponseException $e) {
            $message = 'Service temporarily unavailable';
            $response = new PaymentServiceResponse(false, $message);
        }

        if ($response->result) {
            // Write to DB
        }

        return $response;
    }
}
