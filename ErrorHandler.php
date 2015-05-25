<?php
namespace boundstate\atlas;

/**
 * Error handler that logs exceptions to Atlas.
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * Logs the given exception
     * @param \Exception $exception the exception to be logged
     */
    public function logException($exception)
    {
        parent::logException($exception);
        \Yii::$app->atlas->logException($exception);
    }
}