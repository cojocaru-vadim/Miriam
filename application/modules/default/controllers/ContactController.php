<?php

class ContactController extends Zend_Controller_Action
{

    public function preDispatch(){
        //$this->_helper->layout->setLayout('layout');
    }
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->sent = false;
        if ($this->getRequest()->isPost()) {
            $post = $this->_request->getPost();
            //            dump($post);
            $messaga = "On ".date("Y-m-d H:i:s")." <br />
              his/her name is: ".$post['name']." <br />
              his/her email is: ".$post['email']." <br />
              and he wrote: " . $post['textarea'];
            Moldova_Utils::initiateMail($messaga);

            Moldova_Utils::$MAIL->addTo('cojocaru.vadim@gmail.com', "Cojocaru Vadim");
            //Moldova_Utils::$MAIL->addTo('r.necvetaev@ef-md.com', "Necvetaev Ruslan");
            Moldova_Utils::$MAIL->setSubject('Fasade.md');

            //Moldova_Utils::$MAIL->send(Moldova_Utils::getSMTP());
            Moldova_Utils::$MAIL->send();
            $this->view->sent = true;
        }

    }


}

