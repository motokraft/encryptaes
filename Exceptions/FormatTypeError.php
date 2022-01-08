<?php namespace Motokraft\EncryptAes\Exceptions;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

class FormatTypeError extends \Exception
{
    protected $class;

    function __construct(string $class, int $code = 404)
    {
        $this->class = $class;

        $message = 'Format "' . $class . '" not found!';
        parent::__construct($message, $code);
    }

    function getClass()
    {
        return $this->class;
    }
}