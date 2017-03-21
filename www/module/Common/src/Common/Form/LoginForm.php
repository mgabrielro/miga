<?php

namespace Common\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

/**
 * Class LoginForm
 *
 * @package Common\Form
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'placeholder' => 'Email Address...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Password Here...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }
}