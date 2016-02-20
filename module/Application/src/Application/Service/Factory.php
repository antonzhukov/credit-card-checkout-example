<?php
/**
 * @author zhukov
 */

namespace Application\Service;

use Application\Model\Payment;
use Zend\Db\Adapter\Adapter;
use Monolog\Logger;

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

    public function __construct(Adapter $dbAdapter, Logger $logger, $config)
    {
        $this->data['adapter'] = $dbAdapter;
        $this->data['config'] = $config;
        $this->data['logger'] = $logger;
    }

    /**
     * @return Payment
     */
    public function getModelPayment()
    {
        if (!array_key_exists('modelPayment', $this->data)) {
            $this->data['modelPayment'] = new Payment(
                new Payment\Dao\Mysql($this->getDbAdapter()),
                new Payment\PaymentService\EuroPaymentGroup(
                    $this->data['config']['payment_service'],
                    $this->getLogger()
                )
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

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return $this->data['logger'];
    }
}