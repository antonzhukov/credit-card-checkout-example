<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment\Dao;


use Application\ValueObject\CreditCardPayment;
use Application\Model\Payment\Dao;
use Zend\Db\Adapter\Adapter;

/**
 * Class Mysql
 * @package Application\Model\Payment\Dao
 */
class Mysql implements Dao
{
    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Mysql constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function savePayment($userId, CreditCardPayment $payment)
    {

    }
}
