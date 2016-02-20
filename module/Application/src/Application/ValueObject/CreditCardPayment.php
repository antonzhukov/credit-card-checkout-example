<?php
/**
 * @author zhukov
 */

namespace Application\ValueObject;

/**
 * Class CreditCardPayment
 * @package Application\Entity
 *
 * @property-read $firstName
 * @property-read $lastName
 * @property-read $amount
 * @property-read $currency
 * @property-read $cardNumber
 * @property-read $cvv
 * @property-read $expireMonth
 * @property-read $expireYear
 */
class CreditCardPayment extends ValueObjectAbstract
{
    protected $firstName;
    protected $lastName;
    protected $amount;
    protected $currency;
    protected $cardNumber;
    protected $cvv;
    protected $expireMonth;
    protected $expireYear;

    /**
     * CreditCardPayment constructor.
     * @param string $firstName
     * @param string $lastName
     * @param float    $amount
     * @param string $currency
     * @param string $cardNumber
     * @param int    $cvv
     * @param string $expireMonth
     * @param string $expireYear
     */
    public function __construct(
        $firstName,
        $lastName,
        $amount,
        $currency,
        $cardNumber,
        $cvv,
        $expireMonth,
        $expireYear
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->cardNumber = $cardNumber;
        $this->cvv = $cvv;
        $this->expireMonth = $expireMonth;
        $this->expireYear = $expireYear;
    }
}
