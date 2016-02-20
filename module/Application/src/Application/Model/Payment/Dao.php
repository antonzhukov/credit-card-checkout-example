<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment;

use Application\ValueObject\PaymentServiceResponse;

/**
 * Interface Adapter
 * @package Application\Model\Payment\Db
 */
interface Dao
{
    /**
     * Save user payment attempt
     *
     * @param $userId
     * @param PaymentServiceResponse $payment
     * @return mixed
     */
    public function savePayment($userId, PaymentServiceResponse $payment);
}
