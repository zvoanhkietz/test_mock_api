<?php
namespace Tests\Helper\Fixture;

class FixtureManager{
    /**
     * Holds the fixture classes that where instantiated
     */
    protected $_loaded = [];


    /**
     * List of TestCase class name that have been processed
     *
     * @var array
     */
    protected $_processed = [];

    public function fixturize($test)
    {
        if (empty($test->fixtures) || !empty($this->_processed[get_class($test)])) {
            return;
        }
        $this->_loadFixtures($test);
        $this->_processed[get_class($test)] = true;
    }

    protected function _loadFixtures($test)
    {
        if (empty($test->fixtures)) {
            return;
        }

        foreach ($test->fixtures as $fixture) {
            if (isset($this->_loaded[$fixture])) {
                continue;
            }

            if (class_exists($fixture)) {
                $this->_loaded[$fixture] = new $fixture();
            }else{
                $msg = sprintf(
                    'Referenced fixture class "%s" not found. Fixture "%s" was referenced in test case "%s".',
                    $fixture,
                    $fixture,
                    get_class($test)
                );
                throw new \UnexpectedValueException($msg);
            }
        }
    }

    public function loaded()
    {
        return $this->_loaded;
    }

    public function load($test)
    {
        if (empty($test->fixtures)) {
            return;
        }

        foreach($this->_loaded as $fixture){
            $fixture->initData();
        }
    }

    public function unload($test)
    {
        if (empty($test->fixtures)) {
            return;
        }

        foreach($this->_loaded as $fixture){
            $fixture->clear();
        }
    }
    
    public function shutDown()
    {
        foreach($this->_loaded as $fixture){
            $fixture->clear();
        }
    }
}
