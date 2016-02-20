<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment;


use Application\ValueObject\CreditCardPayment;
use Application\ValueObject\PaymentServiceResponse;

/**
 * Interface PaymentService
 * @package Application\Model\Payment
 */
interface PaymentService
{
    /**
     * @param CreditCardPayment $payment
     * @return PaymentServiceResponse
     */
    public function processCreditCardPayment(CreditCardPayment $payment);
}
