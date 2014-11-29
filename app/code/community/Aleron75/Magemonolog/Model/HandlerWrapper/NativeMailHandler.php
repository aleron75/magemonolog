<?php
use Monolog\Logger;
use \Monolog\Handler\NativeMailerHandler;

class Aleron75_Magemonolog_Model_HandlerWrapper_NativeMailHandler
    extends Aleron75_Magemonolog_Model_HandlerWrapper_AbstractHandler
{
    public function __construct(array $args)
    {
        $this->_validateArgs($args);
        $this->_handler = new NativeMailerHandler(
            $args['to'],
            $args['subject'],
            $args['from'],
            $args['level'],
            $args['bubble'],
            $args['maxColumnWidth']
        );
    }

    protected function _validateArgs(array &$args)
    {
        parent::_validateArgs($args);

        // To
        $args['to'] = trim($args['to']);

        // Subject
        $args['subject'] = trim($args['subject']);

        // From
        $args['from'] = trim($args['from']);

        // Max Column Width
        $maxColumnWidth = null;
        if (isset($args['maxColumnWidth']) && is_numeric($args['maxColumnWidth']))
        {
            $maxColumnWidth = filter_var($args['maxColumnWidth'], FILTER_VALIDATE_INT);
        }
        $args['maxColumnWidth'] = $maxColumnWidth;
    }
}