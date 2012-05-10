<?php

class IndexController extends Zend_Controller_Action
{

    public function preDispatch(){
        $this->_helper->layout->setLayout('home_layout');
    }
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }


}

