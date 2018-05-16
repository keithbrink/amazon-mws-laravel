<?php

class Log
{
    static function info($message)
    {
        error_log('[] '. $message . "\n",3,dirname(__FILE__) . '../../../../log.txt');
    }
    static function notice($message)
    {
        error_log('[] '. $message . "\n",3,dirname(__FILE__) . '../../../../log.txt');
    }
    static function warning($message)
    {
        error_log('[] '. $message . "\n",3,dirname(__FILE__) . '../../../../log.txt');
    }
    static function error($message)
    {
        error_log('[] '. $message . "\n",3,dirname(__FILE__) . '../../../../log.txt');
    }
}