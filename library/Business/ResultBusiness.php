<?php
/**
 * Created by PhpStorm.
 * User: Neemias
 * Date: 24/08/2017
 * Time: 16:21
 */

namespace Business;

class ResultBusiness
{
    private $type;
    private $data;

    /**
     * @param $type
     * @param null $data
     */
    public function __construct($type, $data = \NULL){
        $this->setType($type);
        $this->setData($data);

        return $this;
    }

    /**
     * @param $type
     */
    public function setType($type){
        $this->type = $type;
    }

    /**
     * @param $data
     */
    public function setData($data){
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData(){
        return $this->data;
    }

}