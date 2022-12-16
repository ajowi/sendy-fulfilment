<?php

namespace Ajowi\SendyFulfilment\Exceptions;
use Exception;
use Psr\Http\Client\Exception\RequestException as PsrRequestException;

class RequestException extends Exception implements PsrRequestException
{
}
