<?php
use Monolog\Logger;
use \Monolog\Handler\NativeMailerHandler;

class Aleron75_Magemonolog_Model_HandlerWrapper_NativeMailHandler
    implements Aleron75_Magemonolog_Model_HandlerWrapper_HandlerInterface
{
    protected $_handler = null;

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
        if (!is_array($args))
        {
            $args = array();
        }

        // To
        $args['to'] = trim($args['to']);

        // Subject
        $args['subject'] = trim($args['subject']);

        // From
        $args['from'] = trim($args['from']);

        // Level
        $level = Logger::DEBUG;
        if (isset($args['level']))
        {
            if (is_numeric($args['level']))
            {
                $level = filter_var($args['level'], FILTER_VALIDATE_INT);
            }
            else
            {
                $level = constant('Monolog\Logger::'. $args['level']);
            }

            if (is_null($level))
            {
                $level = Logger::DEBUG;
            }
        }
        $args['level'] = $level;

        // Bubble
        $bubble = true;
        if (isset($args['bubble']))
        {
            $bubble = filter_var($args['bubble'], FILTER_VALIDATE_BOOLEAN);
        }
        $args['bubble'] = $bubble;

        // Max Column Width
        $maxColumnWidth = null;
        if (isset($args['maxColumnWidth']) && is_numeric($args['maxColumnWidth']))
        {
            $maxColumnWidth = filter_var($args['maxColumnWidth'], FILTER_VALIDATE_INT);
        }
        $args['maxColumnWidth'] = $maxColumnWidth;
    }

    public function getHandler()
    {
        return $this->_handler;
    }
}