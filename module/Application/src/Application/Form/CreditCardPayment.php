<?php

namespace Application\Form;


use Zend\Form\FormInterface;

class CreditCardPayment extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('credit-card-payment');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));

        $this->add([
            'name' => 'first_name',
            'type' => 'text',
            'required' => true,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'name' => 'last_name',
            'required' => true,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Last Name',
            ],
        ]);

        $this->add([
            'name' => 'card_number',
            'required' => true,
            'attributes' => [
                'id' => 'card_number',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Card Number',
            ],
        ]);

        $this->add([
            'name' => 'cvv',
            'required' => true,
            'attributes' => [
                'id' => 'cvv',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'CVV',
            ],
        ]);

        $this->add([
            'name' => 'expire',
            'required' => true,
            'attributes' => [
                'id' => 'expire',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Expire date',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Send',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    public function getData($flag = FormInterface::VALUES_NORMALIZED)
    {
        $data = parent::getData();

        // We don't want customer CC info to be stored in global object
        foreach ($data as $key => $item) {
            unset($_POST[$key]);
        }

        if (isset($data['expire']) && strstr($data['expire'], '/')) {
            list($data['expire_month'], $data['expire_year']) = explode('/', $data['expire']);
        }
        unset($data['Submit'], $data['expire']);


        return $data;
    }
}
