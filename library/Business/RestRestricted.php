<?php
/**
 * Created by PhpStorm.
 * User: Neemias
 * Date: 24/08/2017
 * Time: 17:20
 */
namespace Business;

class RestRestricted extends \Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
    }

    public function getAction()
    {
    }

    public function postAction()
    {
    }

    public function putAction()
    {
    }

    public function deleteAction()
    {
    }

    public function headAction()
    {
    }

    public function optionsAction()
    {
    }

}