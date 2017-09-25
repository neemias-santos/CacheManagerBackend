<?php


namespace Business;

/**
 * Class BeersBusiness
 * @package Business
 */
class BeersBusiness extends Business
{

    /**
     * Default bussiness research, working manager the requests
     *
     * @param $config
     * @param $params
     * @return mixed
     * @throws \Zend_Exception
     */
    public function search(array $config, array $params)
    {
        $cache = \Zend_Registry::get('cache');
        $url = $config['url'] . 'beers/';

        $params = $this->simpleClean($params);

        try {
            $cacheBeer = \Constants::CACHED_BEER;

            if (!$cache->load($cacheBeer)) {

                // new HTTP request to some HTTP address
                $httpClient = new \Zend_Http_Client($url);
                // Setting login default
                $httpClient->setParameterGet('key', $config['key']);
                //Default styleId (Basics users can't get a full listing without being required to set one of the parameters)
                $httpClient->setParameterGet(array('styleId' => rand(1, 22)));
                //Additional parameters
                $httpClient->setParameterGet(array('withBreweries' => 'Y'));
                // GET the response
                $response = $this->objectToArray(
                    json_decode(
                        $httpClient->request()->getBody()
                    )
                );

                //Check all results for beers discarding those without data
                $checkBeer = $this->checkBeer($response['data']);
                $resultBeer = $checkBeer;

                $cache->save($resultBeer, $cacheBeer);
            }

            // load data from memcached
            $result = $cache->load($cacheBeer);

            return $result;

        } catch (\Zend_Exception $e) {
            throw new \Zend_Exception($e->getMessage());
        }
    }

    public function searchByName(array $config, array $params)
    {
        $params = $this->simpleClean($params);

        try {
            $cache = \Zend_Registry::get('cache');
            $url = $config['url'] . 'beers/';

            $cacheBeer = \Constants::CACHED_BEER;

            // new HTTP request to some HTTP address
            $httpClient = new \Zend_Http_Client($url);
            // Setting login default
            $httpClient->setParameterGet('key', $config['key']);
            //Default styleId (Basics users can't get a full listing without being required to set one of the parameters)
            $httpClient->setParameterGet($params);
            //Additional parameters
            $httpClient->setParameterGet(array('withBreweries' => 'Y'));
            // GET the response
            $response = $this->objectToArray(
                json_decode(
                    $httpClient->request()->getBody()
                )
            );

            $resultBeer = $response['data'][0];

            // load data from memcached
            $result = $cache->load($cacheBeer);

            if (isset($result) && !empty($result)) {

                //check whether new result is not in cache
                $filterBy = $resultBeer['id'];
                $checkCacheBeer = array_filter($result, function ($var) use ($filterBy) {
                    return ($var['id'] == $filterBy);
                });

                //add the value into cache to avoid do new request to db
                if (!$checkCacheBeer) {
                    $result[] = $resultBeer;
                    $cache->save($result, $cacheBeer);
                }
            }

            return $resultBeer;

        } catch (\Zend_Exception $e) {
            throw new \Zend_Exception($e->getMessage());
        }
    }
}