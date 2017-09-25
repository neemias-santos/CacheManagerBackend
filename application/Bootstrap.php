<?php
use Business\CacheBusiness;
/**
 * Bootstrao Class
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Zend Loader
     *
     * @return void
     */
    protected function _initAutoLoader()
    {
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }

    protected function _initCache()
    {
        $options = $this->getOptions();

        if (isset($options['cache'])) {
            $cache = Zend_Cache::factory(
                $options['cache']['frontend']['type'],
                $options['cache']['backend']['type'],
                $options['cache']['frontend']['options'],
                $options['cache']['backend']['options']
            );

            Zend_Registry::set('cache', $cache);
            return $cache;
        }
    }
}

