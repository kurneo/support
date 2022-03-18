<?php declare(strict_types=1);

namespace Kurneo\Support\Traits;

trait Log
{
    /**
     * Log debug
     *
     * @param string $message
     * @param array $context
     */
    public function debug(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->debug($message, $context);
    }

    /**
     * Print log debug
     *
     * @param string $message
     * @param array $context
     */
    public function printDebug(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'DEBUG',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log info
     *
     * @param string $message
     * @param array $context
     */
    public function info(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->info($message, $context);
    }

    /**
     * Print log info
     *
     * @param string $message
     * @param array $context
     */
    public function printInfo(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'INFO',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log notice
     *
     * @param string $message
     * @param array $context
     */
    public function notice(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->notice($message, $context);
    }

    /**
     * Print log notice
     *
     * @param string $message
     * @param array $context
     */
    public function printNotice(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'NOTICE',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log warning
     *
     * @param string $message
     * @param array $context
     */
    public function warning(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->warning($message, $context);
    }

    /**
     * Print log warning
     *
     * @param string $message
     * @param array $context
     */
    public function printWarning(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'WARNING',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log error
     *
     * @param string $message
     * @param array $context
     */
    public function error(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->error($message, $context);
    }

    /**
     * Print log error
     *
     * @param string $message
     * @param array $context
     */
    public function printError(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'ERROR',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log critical
     *
     * @param string $message
     * @param array $context
     */
    public function critical(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->critical($message, $context);
    }

    /**
     * Print log critical
     *
     * @param string $message
     * @param array $context
     */
    public function printCritical(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'CRITICAL',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log alert
     *
     * @param string $message
     * @param array $context
     */
    public function alert(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->alert($message, $context);
    }

    /**
     * Print log alert
     *
     * @param string $message
     * @param array $context
     */
    public function printAlert(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'ALERT',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log emergency
     *
     * @param string $message
     * @param array $context
     */
    public function emergency(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "%s (at %s:%s)",
            $message,
            $backtrace['file'],
            $backtrace['line']
        );

        app('log')->emergency($message, $context);
    }

    /**
     * Print log emergency
     *
     * @param string $message
     * @param array $context
     */
    public function printEmergency(string $message, array $context = [])
    {
        $backtrace = called_backtrace();

        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'EMERGENCY',
            $message,
            $backtrace['file'],
            $backtrace['line'],
            $context ? json_encode($context) : null
        );

        echo $message . PHP_EOL;
    }

    /**
     * Log exception
     *
     * @param \Throwable $exception
     * @param array $context
     */
    public function exception(\Throwable $exception, array $context = [])
    {
        $message = sprintf(
            "%s (at %s:%s)\n[stacktrace]\n%s",
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        app('log')->error($message, $context);
    }

    /**
     * Print log exception
     *
     * @param \Throwable $exception
     * @param array $context
     */
    public function printException(\Throwable $exception, array $context = [])
    {
        $message = sprintf(
            "[%s] %s.%s: %s (at %s:%s) %s \n[stacktrace]\n%s",
            date('Y-m-d H:i:s'),
            env('APP_ENV'),
            'ERROR',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $context ? json_encode($context) : null,
            $exception->getTraceAsString()
        );

        echo $message . PHP_EOL;
    }
}
