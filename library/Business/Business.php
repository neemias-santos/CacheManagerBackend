<?php

/**
 * Created by PhpStorm.
 * User: Neemias
 * Date: 23/08/2017
 * Time: 18:40
 */

namespace Business;

abstract class Business
{
    function __construct()
    {
        $serverUrlHelper = new \Zend_View_Helper_ServerUrl();
        $this->_baseUrl = $serverUrlHelper->serverUrl();
    }

    /**
     * Method that convert object to array
     *
     * @param $object
     * @return array|null
     */
    public function objectToArray($object)
    {
        $new = null;

        if (is_object($object)) {
            $object = (array)$object;
            foreach ($object as $key => $val) {
                if (is_object($val)) {
                    $object[$key] = self::objectToArray($val);
                }
                if (is_string($val)) {
                    if (trim($val) == '') {
                        unset($object[$key]);
                    } else {
                        $object[$key] = trim($val);
                    }
                }
            }

        }

        if (!$object && $object !== '0') {
            return null;
        }

        if (is_array($object)) {
            $new = array();
            foreach ($object as $key => $val) {
                $key = preg_replace("/^\\0(.*)\\0/", "", $key);
                $key = str_replace("key_", "", $key);
                $new[$key] = self::objectToArray($val);
            }
        } else {
            $new = $object;
        }
        return $new;
    }

    public function checkBeer(array $response)
    {
        $return = [];
        foreach ($response as $value) {
            if (isset($value['description']) && isset($value['labels'])) {
                $return[] = $value;
            }
        }

        return $return;
    }

    /**
     * Remove unnecessary data
     *
     * @param $data
     * @return array
     */
    public function simpleClean($data)
    {
        if (isset($data['controller'])) {
            unset($data['controller']);
        }
        if (isset($data['module'])) {
            unset($data['module']);
        }
        if (isset($data['action'])) {
            unset($data['action']);
        }

        return $data;
    }
}