<?php
/**
 * The Logger class is responsible for logging uncaught
 * exceptions to a file for debugging.
 */
class VIH_Logger implements SplObserver
{
    protected $filename;

    function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Update the error_log with
     * information about the Exception.
     *
     * @param SplSubject $subject   The ExceptionHandler
     * @return boolean
     */
    public function update(SplSubject $subject)
    {
        return error_log($subject->getException(), 0, $this->filename);
    }
}
