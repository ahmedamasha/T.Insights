<?php

namespace Tajawal\Nitro\Exceptions;

/**
 * Class BadRequestException
 *
 * @package App\Exceptions
 *
 * @author  Kamran Ahmed <kamran.ahmed@tajawal.com>
 */
class BadRequestException extends BaseException
{
    protected $status     = '400';
    protected $title      = 'Bad Request';
    protected $detail     = '';
    protected $additional = [];

    /**
     * BadRequestException constructor.
     *
     * @param string|\Tajawal\Nitro\Helpers\ResponseErrors $detail
     * @param string                                       $title
     */
    public function __construct($detail, $title = '', array $additional = [])
    {
        $this->detail     = $detail ?: $this->detail;
        $this->title      = $title ?: $this->title;
        $this->additional = $additional;

        parent::__construct($this->detail);
    }
}
