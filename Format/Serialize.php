<?php namespace Motokraft\EncryptAes\Format;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

use \Motokraft\Object\BaseObject;

class Serialize implements FormatInterface
{
    function encode(array $data)
    {
        return serialize($data);
    }

    function decode(string $result)
    {
        $data = unserialize($result);
        $result = new BaseObject;

        $result->loadArray($data);
        return $result;
    }
}