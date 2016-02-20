<?php
/**
 * @author zhukov
 */

namespace Application\Service;

use Application\Model\Payment;
use Zend\Db\Adapter\Adapter;

/**
 * Class Factory
 * @package Application\Service
 */
class Factory
{
    /**
     * Storage of models
     * @var array
     */
    protected $data = [];

    public function __construct(Adapter $dbAdapter, $config)
    {
        $this->data['adapter'] = $dbAdapter;
        $this->data['config'] = $config;
    }

    /**
     * @return Payment
     */
    public function getModelPayment()
    {
        if (!array_key_exists('modelPayment', $this->data)) {
            $this->data['modelPayment'] = new Payment(
                new Payment\Dao\Mysql($this->getDbAdapter()),
                new Payment\PaymentService\EuroPaymentGroup($this->data['config']['payment_service'])
            );
        }

        return $this->data['modelPayment'];
    }

    /**
     * @return Adapter
     */
    protected function getDbAdapter()
    {
        return $this->data['adapter'];
    }
}