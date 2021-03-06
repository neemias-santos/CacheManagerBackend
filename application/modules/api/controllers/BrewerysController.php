<?php

use \Business\ResultBusiness;

/**
 * Created by PhpStorm.
 * User: Neemias
 * Date: 24/09/2017
 * Time: 09:39
 */
class Api_BrewerysController extends \Business\RestRestricted
{
    /**
     * The head action handles HEAD requests and receives an 'id' parameter; it
     * should respond with the server resource state of the resource identified
     * by the 'id' value.
     */
    public function headAction()
    {
        // TODO: Implement headAction() method.
    }

    public function indexAction()
    {

        if ($this->getRequest()->getParams()) {

            $params = $this->getRequest()->getParams();

            $bootstrap = $this->getInvokeArg('bootstrap');
            $config = $bootstrap->getOption('brewerydb');


            $brewerysBusiness = new \Business\BrewerysBusiness();
            $result = $brewerysBusiness->searchBrewerys($config, $params);

            //random data
            shuffle($result);

            if (isset($result)) {
                $this->getResponse()->appendBody(json_encode(array('beers' => $result)));
                $this->getResponse()->setHttpResponseCode(200);
            } else {
                $this->getResponse()->appendBody(json_encode('Error'));
                $this->getResponse()->setHttpResponseCode(400);
            }
        }
    }

    public function getAction()
    {
        if ($this->getRequest()->getParams()) {

            $params = $this->getRequest()->getParams();

            $bootstrap = $this->getInvokeArg('bootstrap');
            $config = $bootstrap->getOption('brewerydb');


            $brewerysBusiness = new \Business\BrewerysBusiness();
            $result = $brewerysBusiness->searchBrewerysByName($config, $params);

            if (isset($result)) {
                $this->getResponse()->appendBody(json_encode(array('beers' => $result)));
                $this->getResponse()->setHttpResponseCode(200);
            } else {
                $this->getResponse()->appendBody(json_encode('Error'));
                $this->getResponse()->setHttpResponseCode(400);
            }
        }
    }

    public function postAction()
    {
        // TODO: Implement postAction() method.
    }

    public function putAction()
    {
        // TODO: Implement putAction() method.
    }

    public function deleteAction()
    {
        // TODO: Implement deleteAction() method.
    }

}