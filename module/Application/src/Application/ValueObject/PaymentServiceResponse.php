<?php
/**
 * @author zhukov
 */

namespace Application\ValueObject;

/**
 * Class CreditCardPayment
 * @package Application\Entity
 *
 * @property-read bool   $result
 * @property-read string $message
 */
class PaymentServiceResponse extends ValueObjectAbstract
{
    protected $result;
    protected $message;

    /**
     * PaymentServiceResponse constructor.
     * @param bool   $result
     * @param string $message
     */
    public function __construct(
        $result,
        $message
    ) {
        $this->result = $result;
        $this->message = $message;
    }
}
