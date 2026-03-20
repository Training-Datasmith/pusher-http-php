<?php

declare (strict_types=1);
namespace Pusher;

/**
 * HTTP error responses.
 * getCode() will return the response HTTP status code,
 * and getMessage() will return the response body.
 */
class Api_Error_Exception extends Pusher_Exception
{
    /**
     * Returns the string representation of the exception.
     */
    public function __toString(): string
    {
        return "(Status {$this->get_code()}) {$this->get_message()}";
    }
}