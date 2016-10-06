<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class Login extends Form {

    public function __construct() {
        parent::__construct();

        $this->add([
            'name' => 'usuario',
            'options' => [
                'label' => 'Usuário',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'usuário',
                'required'=> 'required'
            ],
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'type' => 'Text',
        ]);

        $this->add([
            'name' => 'senha',
            'options' => [
                'label' => 'Senha',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'senha',
                'required'=> 'required'
            ],
            'type' => 'Password',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Autenticar',
            ],
        ]);

        $this->setAttribute('action', '/login');
        $this->setAttribute('method', 'post');
    }

}
