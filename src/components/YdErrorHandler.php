<?php
/**
 *
 */
class YdErrorHandler extends CErrorHandler
{
    /**
     * @param CEvent $event
     */
    public function handle($event)
    {
        if ($event instanceof CExceptionEvent)
            $this->logException($event);
        else
            $this->logError($event);
        parent::handle($event);
    }

    /**
     * @param $event CEvent|CErrorEvent
     */
    public function logError($event)
    {
        $errorMessage = $this->getErrorHtml($event);
        $dir = app()->getRuntimePath() . '/errors';
        if (!file_exists($dir))
            mkdir($dir, 0777, true);
        $auditId = YdAudit::findCurrentId();
        if (!$auditId)
            $auditId = uniqid();
        $path = $dir . '/audit-' . $auditId . '.html';
        file_put_contents($path, $errorMessage);
    }

    /**
     * @param $event CEvent|CExceptionEvent
     */
    public function logException($event)
    {
        $errorMessage = $this->getExceptionHtml($event->exception);
        $dir = app()->getRuntimePath() . '/errors';
        if (!file_exists($dir))
            mkdir($dir, 0777, true);
        $auditId = YdAudit::findCurrentId();
        if (!$auditId)
            $auditId = uniqid();
        $path = $dir . '/audit-' . $auditId . '.html';
        file_put_contents($path, $errorMessage);
    }

    /**
     * @param $event CEvent|CErrorEvent
     * @return string
     */
    public function getErrorHtml($event)
    {
        ob_start();
        if (app() instanceof CWebApplication) {
            $trace = debug_backtrace();
            // skip the first 3 stacks as they do not tell the error position
            if (count($trace) > 6)
                $trace = array_slice($trace, 6);
            $traceString = '';
            foreach ($trace as $i => $t) {
                if (!isset($t['file']))
                    $trace[$i]['file'] = 'unknown';

                if (!isset($t['line']))
                    $trace[$i]['line'] = 0;

                if (!isset($t['function']))
                    $trace[$i]['function'] = 'unknown';

                $traceString .= "#$i {$trace[$i]['file']}({$trace[$i]['line']}): ";
                if (isset($t['object']) && is_object($t['object']))
                    $traceString .= get_class($t['object']) . '->';
                $traceString .= "{$trace[$i]['function']}()\n";

                unset($trace[$i]['object']);
            }
            switch ($event->code) {
                case E_WARNING:
                    $type = 'PHP warning';
                    break;
                case E_NOTICE:
                    $type = 'PHP notice';
                    break;
                case E_USER_ERROR:
                    $type = 'User error';
                    break;
                case E_USER_WARNING:
                    $type = 'User warning';
                    break;
                case E_USER_NOTICE:
                    $type = 'User notice';
                    break;
                case E_RECOVERABLE_ERROR:
                    $type = 'Recoverable error';
                    break;
                default:
                    $type = 'PHP error';
            }
            $data = array(
                'code' => 500,
                'type' => $type,
                'message' => $event->message,
                'file' => $event->file,
                'line' => $event->line,
                'trace' => $traceString,
                'traces' => $trace,
            );
            $data['version'] = $this->getVersionInfo();
            $data['time'] = time();
            $data['admin'] = $this->adminInfo;
            ob_start();
            $this->render('application.views.error.exception', $data);
        }
        else {
            app()->displayError($event->code, $event->message, $event->file, $event->line);
        }
        return ob_get_clean();
    }

    /**
     * @param $exception CEvent|CException
     * @return string
     */
    public function getExceptionHtml($exception)
    {
        ob_start();
        if (app() instanceof CWebApplication) {
            if (($trace = $this->getExactTrace($exception)) === null) {
                $fileName = $exception->getFile();
                $errorLine = $exception->getLine();
            }
            else {
                $fileName = $trace['file'];
                $errorLine = $trace['line'];
            }

            $trace = $exception->getTrace();

            foreach ($trace as $i => $t) {
                if (!isset($t['file']))
                    $trace[$i]['file'] = 'unknown';

                if (!isset($t['line']))
                    $trace[$i]['line'] = 0;

                if (!isset($t['function']))
                    $trace[$i]['function'] = 'unknown';

                unset($trace[$i]['object']);
            }

            $data = array(
                'code' => ($exception instanceof CHttpException) ? $exception->statusCode : 500,
                'type' => get_class($exception),
                'errorCode' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $fileName,
                'line' => $errorLine,
                'trace' => $exception->getTraceAsString(),
                'traces' => $trace,
            );
            $this->render('application.views.error.exception', $data);
        }
        else {
            app()->displayException($exception);
        }
        return ob_get_clean();
    }

}
