<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Service\Factory;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
    private $factory;

    /**
     * @return Factory
     */
    protected function getFactory()
    {
        if (!$this->factory) {
            $this->factory = $this->getServiceLocator()->get('Factory');
        }
        return $this->factory;
    }

    protected function getUserId()
    {
        return 123;
    }
}
