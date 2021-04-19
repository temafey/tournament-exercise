<?php


namespace Tournament\Tools;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerInitializer
{
    protected const LOG_PATH = './log/';
    protected const LOGGER_DEFAULT_NAME = 'app';

    public static function get(string $name = self::LOGGER_DEFAULT_NAME): Logger
    {
        $log = new Logger($name);
        $log->pushHandler(new StreamHandler(self::LOG_PATH . 'info.log', Logger::INFO));

        return $log;
    }

}