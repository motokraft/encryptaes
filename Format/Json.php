<?php namespace Motokraft\EncryptAes\Format;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

use \Motokraft\Object\BaseObject;

class Json implements FormatInterface
{
    private $flags = 0;
    private $depth = 512;

    function setFlag(int $value)
    {
        $this->flags = (int) $value;
        return $this;
    }

    function setGepth(int $value)
    {
        $this->depth = (int) $value;
        return $this;
    }

    function getFlag()
    {
        return $this->flags;
    }

    function getGepth()
    {
        return $this->depth;
    }

    function encode(array $data)
    {
        $flags = $this->getFlag();
        $depth = $this->getGepth();

        $result = json_encode($data, $flags, $depth);
        $last_error = (int) json_last_error();

        if($last_error !== JSON_ERROR_NONE)
        {
            $message = json_last_error_msg($last_error);
            throw new \Exception($message);
        }

        return $result;
    }

    function decode(string $result)
    {
        $data = (array) json_decode($result);
        $last_error = (int) json_last_error();

        if($last_error !== JSON_ERROR_NONE)
        {
            $message = json_last_error_msg($last_error);
            throw new \Exception($message);
        }

        $result = new BaseObject();
        $result->loadArray($data);

        return $result;
    }
}