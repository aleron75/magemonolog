<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Aleron75_Magemonolog_Model_HandlerWrapper_StreamHandler
    extends Aleron75_Magemonolog_Model_HandlerWrapper_AbstractHandler
{
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
        parent::_validateArgs($args);

        // Stream
        $file = Mage::getStoreConfig('dev/log/file');
        if (isset($args['stream']))
        {
            $file = $args['stream'];
        }
        $logDir  = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . $file;
        $args['stream'] = $logFile;

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
}