<?php
use Monolog\Logger;
use \Monolog\Handler\NewRelicHandler;

class Aleron75_Magemonolog_Model_HandlerWrapper_NewRelicHandler
    extends Aleron75_Magemonolog_Model_HandlerWrapper_AbstractHandler
{
    public function __construct(array $args)
    {
        $this->_validateArgs($args);
        $this->_handler = new NewRelicHandler(
            $args['level'],
            $args['bubble'],
            $args['appname']
        );
    }

    protected function _validateArgs(array &$args)
    {
        parent::_validateArgs($args);

        // Appname
        $appname = '';
        if (isset($args['appname']))
        {
            $appname = trim($args['appname']);
        }
        $args['appname'] = $appname;
    }
}