<?php

namespace App\Enums;


final class StatusCode
{
    const OK = 200;
    const INTERNAL_ERR = 500;
    const ERROR = 'error';
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const GONE = 410;

}
