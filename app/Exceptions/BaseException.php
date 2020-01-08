<?php

namespace Tajawal\Nitro\Exceptions;

use Exception;

/**
 * Class BaseException
 *
 * Abstract Exception class that all of the application specific exceptions will extend from. This will make it
 * easy to catch all of the application specific exceptions and provides a clean separation from the other
 * potential exceptions that may be thrown during the application’s execution.
 *
 * @package App\Exceptions
 *
 * @author  Kamran Ahmed <kamran.ahmed@tajawal.com>
 */
abstract class BaseException extends Exception
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @var string
     */
    protected $trace;

    /**
     * @var array
     */
    protected $additional = [];

    /**
     * Get the status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->status;
    }

    /**
     * Return the Exception as an array
     *
     * @return array
     */
    public function toArray()
    {
        $details = array_merge([
            'status' => $this->status,
            'title'  => $this->title,
            'detail' => $this->detail,
            'type'   => !empty($this->type) ? $this->type : 'https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
            'trace'  => $this->trace,
        ], $this->additional);

        return array_filter($details);
    }
}
