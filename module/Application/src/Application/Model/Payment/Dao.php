<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment;

use Application\ValueObject\CreditCardPayment;

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
     * @param CreditCardPayment $payment
     * @return mixed
     */
    public function savePayment($userId, CreditCardPayment $payment);
}
