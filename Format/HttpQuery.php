<?php namespace Motokraft\EncryptAes\Format;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

use \Motokraft\Object\BaseObject;

class HttpQuery implements FormatInterface
{
    private $numeric_prefix;
    private $arg_separator;
    private $encoding_type;

    function setNumericPrefix(string $value)
    {
        $this->numeric_prefix = $value;
        return $this;
    }

    function setArgSeparator(string $value)
    {
        $this->arg_separator = $value;
        return $this;
    }

    function setEncodingType(int $value)
    {
        $this->encoding_type = (int) $value;
        return $this;
    }

    function getNumericPrefix()
    {
        return $this->numeric_prefix;
    }

    function getArgSeparator()
    {
        return $this->arg_separator;
    }

    function getEncodingType()
    {
        return $this->encoding_type;
    }

    function encode(array $data)
    {
        return http_build_query($data);
    }

    function decode(string $result)
    {
        parse_str($result, $data);
        $result = new BaseObject;

        $result->loadArray($data);
        return $result;
    }
}