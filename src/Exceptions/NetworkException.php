<?php

namespace Ajowi\SendyFulfilment\Exceptions;

use Exception;
use Psr\Http\Client\Exception\NetworkException as PsrNetworkException;

class NetworkException extends Exception implements PsrNetworkException
{
}
