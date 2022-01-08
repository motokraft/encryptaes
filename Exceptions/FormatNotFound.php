<?php namespace Motokraft\EncryptAes\Exceptions;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

class FormatNotFound extends \Exception
{
    protected $formater;

    function __construct(string $formater, int $code = 404)
    {
        $this->formater = $formater;

        $message = 'Format "' . $formater . '" not found!';
        parent::__construct($message, $code);
    }

    function getFormater()
    {
        return $this->formater;
    }
}