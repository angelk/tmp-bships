<?php

namespace Error;

/**
 * Description of ErrorHandler
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class ErrorHandler
{
    /**
     * Register custom Error and Exception handlers
     */
    public function register()
    {
        set_error_handler("Error\\ErrorHandler::handlerError");
        set_exception_handler("Error\\ErrorHandler::handleException");
    }

    /**
     * Register error handler
     * @param int $errno
     * @param string $errstr
     * @param strig $errfile
     * @param int $errline
     * @throws \Exception
     */
    public static function handlerError($errno, $errstr, $errfile, $errline)
    {
        throw new \Exception("({$errno}) {$errstr}. {$errfile}:{$errline}");
    }
    
    /**
     * Handle exceptions
     * @param \Exception $exception
     */
    public static function handleException($exception)
    {
        // error should be logger.
        echo $exception;
    }
}
