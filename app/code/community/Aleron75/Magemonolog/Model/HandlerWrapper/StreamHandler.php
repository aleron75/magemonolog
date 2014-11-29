<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Aleron75_Magemonolog_Model_HandlerWrapper_StreamHandler
    implements Aleron75_Magemonolog_Model_HandlerWrapper_HandlerInterface
{
    protected $_handler = null;

    public function __construct(array $args)
    {
        $this->_validateArgs($args);
        $this->_handler = new StreamHandler(
            $args['stream'],
            $args['level'],
            $args['bubble'],
            $args['filePermission'],
            $args['useLocking']
        );
    }

    protected function _validateArgs(array &$args)
    {
        if (!is_array($args))
        {
            $args = array();
        }

        // Stream
        $file = Mage::getStoreConfig('dev/log/file');
        if (isset($args['stream']))
        {
            $file = $args['stream'];
        }
        $logDir  = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . $file;
        $args['stream'] = $logFile;

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

        // File Permission
        $filePermission = null;
        if (isset($args['filePermission']) && is_numeric($args['filePermission']))
        {
            $filePermission = filter_var($args['filePermission'], FILTER_VALIDATE_INT);
        }
        $args['filePermission'] = $filePermission;

        // Use Locking
        $useLocking = false;
        if (isset($args['useLocking']))
        {
            $useLocking = filter_var($args['useLocking'], FILTER_VALIDATE_BOOLEAN);
        }
        $args['useLocking'] = $useLocking;
    }

    public function getHandler()
    {
        return $this->_handler;
    }
}