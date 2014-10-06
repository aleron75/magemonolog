<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Aleron75_Magemonolog_Model_Logwriter
    extends Zend_Log_Writer_Abstract
{
    /**
     * @var string
     */
    protected $_logFile = null;

    /**
     * @var Monolog\Logger
     */
    protected $_logger = null;

    /**
     * Array used to map Zend's log levels into Monolog's
     *
     * @var array
     */
    protected $_levelMap = array();

    public function __construct($logFile)
    {
        $this->_logFile = $logFile;

        // Force autoloading
        Mage::dispatchEvent('add_spl_autoloader');

        // Initialize level mapping only after the Logger class is loaded
        $this->__initLevelMapping();

        $this->_logger = new Logger('monolog');
        $this->_logger->pushHandler(new StreamHandler($logFile));
    }

    /**
     * Initialize the array used to map Zend's log levels into Monolog's
     */
    private function __initLevelMapping()
    {
        $this->_levelMap = array(
            Zend_Log::EMERG     => Logger::EMERGENCY,
            Zend_Log::ALERT     => Logger::ALERT,
            Zend_Log::CRIT      => Logger::CRITICAL,
            Zend_Log::ERR       => Logger::ERROR,
            Zend_Log::WARN      => Logger::WARNING,
            Zend_Log::NOTICE    => Logger::NOTICE,
            Zend_Log::INFO      => Logger::INFO,
            Zend_Log::DEBUG     => Logger::DEBUG,
        );
    }

    /**
     * Write a message using Monolog.
     *
     * @param  array $event  event data
     * @return void
     */
    protected function _write($event)
    {
        $level = $this->_levelMap[$event['priority']];
        $message = $event['message'];
        $this->_logger->addRecord($level, $message);
        Zend_Debug::dump($event);
    }

    /**
     * Create a new instance of Aleron75_Magemonolog_Model_Logwriter
     *
     * @param  array|Zend_Config $config
     * @return Aleron75_Magemonolog_Model_Logwriter
     * @throws Zend_Log_Exception
     */
    static public function factory($config)
    {
        return new self(self::_parseConfig($config));
    }
}