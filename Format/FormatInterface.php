<?php namespace Motokraft\EncryptAes\Format;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

use \Motokraft\Object\BaseObject;

interface FormatInterface
{
    function encode(array $data);
    function decode(string $result);
}