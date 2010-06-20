<?php
/**
 * The ExceptionHandler class sends uncaught
 * exception messages to the proper handlers.  This is done
 * using the Observer pattern, and SplObserver/SplSubject.
 */
class VIH_ExceptionHandler implements SplSubject
{
    /**
     * An array of SplObserver objects
     * to notify of Exceptions.
     *
     * @var array
     */
    protected $observers = array();

    /**
     * The uncaught Exception that needs
     * to be handled.
     *
     * @var Exception
     */
    protected $exception;

    /**
     * Constructor method for ExceptionHandler.
     *
     * @return ExceptionHandler
     */
    function __construct() { }

    /**
     * Attaches an SplObserver to
     * the ExceptionHandler to be notified
     * when an uncaught Exception is thrown.
     *
     * @param SplObserver        The observer to attach
     * @return void
     */
    public function attach(SplObserver $obs)
    {
        $id = spl_object_hash($obs);
        $this->observers[$id] = $obs;
    }

    /**
     * Detaches the SplObserver from the
     * ExceptionHandler, so it will no longer
     * be notified when an uncaught Exception is thrown.
     *
     * @param SplObserver        The observer to detach
     * @return void
     */
    public function detach(SplObserver $obs)
    {
        $id = spl_object_hash($obs);
        unset($this->observers[$id]);
    }

    /**
     * Notify all observers of the uncaught Exception
     * so they can handle it as needed.
     *
     * @return void
     */
    public function notify()
    {
        foreach($this->observers as $obs)
        {
            $obs->update($this);
        }
    }

    /**
     * This is the method that should be set as the
     * default Exception handler by the calling code.
     *
     * @return void
     */
    public function handle(Exception $e)
    {
        $this->exception = $e;
        $this->notify();
    }

    public function getException()
    {
        return $this->exception;
    }
}
