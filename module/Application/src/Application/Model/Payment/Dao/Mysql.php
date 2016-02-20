<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment\Dao;

use Application\Model\Payment\Dao;
use Application\ValueObject\PaymentServiceResponse;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class Mysql
 * @package Application\Model\Payment\Dao
 */
class Mysql extends AbstractTableGateway implements Dao
{
    /**
     * @var Adapter
     */
    protected $adapter;

    protected $table = 'transaction';

    /**
     * Mysql constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Save user payment attempt
     *
     * @param int                    $userId
     * @param PaymentServiceResponse $payment
     * @return int|bool
     */
    public function savePayment($userId, PaymentServiceResponse $payment)
    {
        $time = time();
        $insert = $this->insert(
            [
                'fk_user' => (int) $userId,
                'created_at' => date('Y-m-d H:i:s', $time),
                'updated_at' => date('Y-m-d H:i:s', $time),
                'is_successful'   => (int) $payment->result,
                'message'   => (string) $payment->message,
            ]
        );
        if ($insert) {
            return $this->lastInsertValue;
        }
        return false;
    }
}
