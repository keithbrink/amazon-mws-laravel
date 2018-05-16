<?php

class Log
{
    public static function info($message)
    {
        error_log('[] '.$message."\n", 3, dirname(__FILE__).'../../../../log.txt');
    }

    public static function notice($message)
    {
        error_log('[] '.$message."\n", 3, dirname(__FILE__).'../../../../log.txt');
    }

    public static function warning($message)
    {
        error_log('[] '.$message."\n", 3, dirname(__FILE__).'../../../../log.txt');
    }

    public static function error($message)
    {
        error_log('[] '.$message."\n", 3, dirname(__FILE__).'../../../../log.txt');
    }
}
