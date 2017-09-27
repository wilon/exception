<?php

/*
 * This file is modified from laravel file ——
 * https://github.com/laravel/framework/blob/5.4/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php
 *
 * (c) Weilong Wang <wilonx@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wilon\Exception;

use Exception;
use ErrorException;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Application as ConsoleApplication;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class Handler
{
    /**
     * The Monolog\Logger object.
     *
     * @var  \Monolog\Logger
     */
    public $logger;

    /**
     * Show debug or not.
     *
     * @var bollean
     */
    public $show = true;

    /**
     * Just for testing this package.
     *
     * @var bollean
     */
    public $testing = false;

    /**
     * Bootstrap the HandleExceptions.
     *
     * @param  int $level The new error_reporting level.
     * @param  string $environment
     * @return void
     */
    public function bootstrap($level = -1, $show = true)
    {
        error_reporting($level);

        set_error_handler([$this, 'handleError']);

        set_exception_handler([$this, 'handleException']);

        register_shutdown_function([$this, 'handleShutdown']);

        if ($this->testing) {
            ini_set('display_errors', 'Off');
        }

        $this->show = $show;

        if (! $this->logger instanceof LoggerInterface) {
            $this->setLogger();
        }
    }

    /**
     * Set up the default \Monolog\Logger
     *
     * @param  string  $loggerName
     * @param  string  $loggerFile
     * @return void
     *
     * @throws \ErrorException
     */
    public function setLogger($loggerName = 'wilon-exceptions', $loggerFile = 'exceptions.log')
    {
        $logger = new Logger($loggerName);
        $handler = new StreamHandler($loggerFile, Logger::WARNING);
        $handler->setFormatter(new LineFormatter(null, null, true));
        $logger->pushHandler($handler);
        $this->logger = $logger;
        return $this;
    }

    /**
     * Convert a PHP error to an ErrorException.
     *
     * @param  int  $level
     * @param  string  $message
     * @param  string  $file
     * @param  int  $line
     * @param  array  $context
     * @return void
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception.
     *
     * Note: Most exceptions can be handled via the try / catch block in
     * the HTTP and Console kernels. But, fatal error exceptions must
     * be handled differently since they are not normal exceptions.
     *
     * @param  \Throwable  $e
     * @return void
     */
    public function handleException($e)
    {
        if (! $e instanceof Exception) {
            $e = new FatalThrowableError($e);
        }

        $this->logger->error($e);

        if (php_sapi_name() == 'cli') {
            (new ConsoleApplication)->renderException($e, new ConsoleOutput);
        } else {
            $exception = new ExceptionHandler($this->show);
            $exception->handle($e);
        }
    }

    /**
     * Handle the PHP shutdown event.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (! is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalExceptionFromError($error, 0));
        }
    }

    /**
     * Create a new fatal exception instance from an error array.
     *
     * @param  array  $error
     * @param  int|null  $traceOffset
     * @return \Symfony\Component\Debug\Exception\FatalErrorException
     */
    protected function fatalExceptionFromError(array $error, $traceOffset = null)
    {
        return new FatalErrorException(
            $error['message'], $error['type'], 0, $error['file'], $error['line'], $traceOffset
        );
    }

    /**
     * Determine if the error type is fatal.
     *
     * @param  int  $type
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }
}