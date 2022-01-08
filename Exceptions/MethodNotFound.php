<?php namespace Motokraft\EncryptAes\Exceptions;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

class MethodNotFound extends \Exception
{
    protected $method;

    function __construct(string $method, int $code = 404)
    {
        $this->method = $method;

        $message = 'Method "' . $method . '" not found!';
        parent::__construct($message, $code);
    }

    function getMethod()
    {
        return $this->method;
    }
}