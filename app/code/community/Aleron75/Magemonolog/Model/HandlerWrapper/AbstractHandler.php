<?php
use Monolog\Logger;

abstract class Aleron75_Magemonolog_Model_HandlerWrapper_AbstractHandler
    implements Aleron75_Magemonolog_Model_HandlerWrapper_HandlerInterface
{
    protected $_handler = null;

    protected function _validateArgs(array &$args)
    {
        if (!is_array($args))
        {
            $args = array();
        }

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
    }

    public function getHandler()
    {
        return $this->_handler;
    }

    /**
     * @param \Monolog\Formatter\FormatterInterface $formatter
     */
    public function setFormatter(\Monolog\Formatter\FormatterInterface $formatter)
    {
        if ($this->_handler) {
            $this->_handler->setFormatter($formatter);
        }
    }

}