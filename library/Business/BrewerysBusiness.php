<?php
/**
 * Created by PhpStorm.
 * User: Neemias
 * Date: 24/09/2017
 * Time: 09:42
 */

namespace Business;


class BrewerysBusiness extends Business
{
    /**
     * Search beer from brewery by id
     *
     * @param $config
     * @param $params
     * @return mixed
     * @throws \Zend_Exception
     */
    public function searchBrewerys(array $config, array $params)
    {

        $params = $this->simpleClean($params);

        $cache = \Zend_Registry::get('cache');
        $url = $config['url'] . 'brewery/';

        try {
            // Sets the name of the cached
            $cacheBeerByBrewery = 'cache_brewery_beers' . $params['breweryId'];

            if (!$cache->load($cacheBeerByBrewery)) {

                // new HTTP request to some HTTP address
                $httpClient = new \Zend_Http_Client();
                $httpClient->setUri($url . $params['breweryId'] . '/beers');
                // Setting login default
                $httpClient->setParameterGet('key', $config['key']);

                // GET the response
                $response = $this->objectToArray(
                    json_decode(
                        $httpClient->request()->getBody()
                    )
                );

                //Check all results for beers discarding those without data
                $checkBeer = $this->checkBeer($response['data']);
                $resultBeer = $checkBeer;

                //load cached beer
                $cacheBeer = $cache->load(\Constants::CACHED_BEER);
                $cacheBeer[] = $resultBeer;

                //save the data into the memcached
                $cache->save($resultBeer, $cacheBeerByBrewery, [], '1728');
            }

            $result = $cache->load($cacheBeerByBrewery);

            return $result;

        } catch (\Zend_Exception $e) {
            throw new \Zend_Exception($e->getMessage());
        }

    }

    public function searchBrewerysByName(array $config, array $params)
    {

        $params = $this->simpleClean($params);

        $cache = \Zend_Registry::get('cache');
        $url = $config['url'] . 'breweries/';

        try {

            // new HTTP request to some HTTP address
            $httpClient = new \Zend_Http_Client($url);
            // Setting login default
            $httpClient->setParameterGet('key', $config['key']);
            //
            $httpClient->setParameterGet('name', $params['name']);

            // GET the response
            $response = $this->objectToArray(
                json_decode(
                    $httpClient->request()->getBody()
                )
            );

            //define brewery
            $brewery = $response['data'][0];

            // Sets the name of the cached of brewery
            $cacheBrewery = 'cache_brewery_' . $brewery['id'];

            //save the data into the memcached
            $cache->save($brewery, $cacheBrewery, [], '1728');

            // Sets the name of the cached of beee of brewery
            $cacheBeerByBrewery = 'cache_brewery_beers' . $brewery['id'];

            // check whether beer alread exist in cached
            if(!$cache->load($cacheBeerByBrewery)){

                $urlBeerByBrewery = $config['url'] . 'brewery/';

                // new HTTP request to some HTTP address
                $httpClient = new \Zend_Http_Client();
                $httpClient->setUri($urlBeerByBrewery . $brewery['id'] . '/beers');
                // Setting login default
                $httpClient->setParameterGet('key', $config['key']);

                // GET the response
                $response = $this->objectToArray(
                    json_decode(
                        $httpClient->request()->getBody()
                    )
                );

                //Check all results for beers discarding those without data
                $checkBeer = $this->checkBeer($response['data']);
                $resultBeer = $checkBeer;

                //load cached beer
                $cacheBeer = $cache->load(\Constants::CACHED_BEER);
                $cacheBeer[] = $resultBeer;

                //save the data into the memcached
                $cache->save($resultBeer, $cacheBeerByBrewery, [], '1728');
            }

            $result = $cache->load($cacheBeerByBrewery);

            return $result;


        } catch (\Zend_Exception $e) {
            throw new \Zend_Exception($e->getMessage());
        }

    }
}