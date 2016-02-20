<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\CreditCardPayment;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $post    = $request->getPost();
        $view = new ViewModel();
        $form = new CreditCardPayment();
        $model = $this->getFactory()->getModelPayment();
        $amount = 100;
        $currency = 'USD';

        $form->prepare();
        $form->setData($post);

        if ($request->isPost() && $form->isValid()) {
            $data = $form->getData();
            $result = $model->processUserPayment(
                $this->getUserId(),
                $data['first_name'],
                $data['last_name'],
                $amount,
                $currency,
                $data['card_number'],
                $data['cvv'],
                $data['expire_month'],
                $data['expire_year']
            );

            if ($result->result) {
                $this->flashMessenger()->addSuccessMessage('Payment successful');
            } else {
                $this->flashMessenger()->addErrorMessage($result->message);
            }

            return $this->redirect()->refresh();
        }

        $view->setVariable('form', $form);
        $view->setVariable('currency', $currency);
        $view->setVariable('amount', $amount);

        return $view;
    }
}
