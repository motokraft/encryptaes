<?php namespace Motokraft\EncryptAes;

/**
 * @copyright   2021 Motokraft. MIT License
 * @link https://github.com/motokraft/encryptaes
 */

use \Motokraft\Object\BaseObject;
use \Motokraft\EncryptAes\Exceptions\MethodNotFound;
use \Motokraft\EncryptAes\Exceptions\FormatNotFound;
use \Motokraft\EncryptAes\Exceptions\FormatClassNotFound;
use \Motokraft\EncryptAes\Exceptions\FormatTypeError;
use \Motokraft\EncryptAes\Format\FormatInterface;

class EncryptAes extends BaseObject
{
    use \Motokraft\Traits\Options;
    use \Motokraft\Traits\CsrfToken;

    private static $options = [
        'method' => 'aes-256-cbc',
        'format' => 'json'
    ];

    private static $formats = [
        'json' => Format\Json::class,
        'httpquery' => Format\HttpQuery::class,
        'serialize' => Format\Serialize::class
    ];

    private $method;
    private $token;
    private $decrypt;
    private $iv;
    private $format;

    function __construct(array $data = [])
    {
        if($method = $this->getOption('method'))
        {
            $this->setMethod($method);
        }

        if($token = self::getCSRFToken())
        {
            $this->setToken($token);
        }

        if($format = $this->getOption('format'))
        {
            $this->loadFormat($format);
        }

        if(!empty($data))
        {
            $this->loadArray($data);
        }
    }

    static function setFormates(array $formats)
    {
        self::$formats = array_merge(self::$formats, $formats);
    }

    static function setFormat(string $name, string $value)
    {
        self::$formats[$name] = $value;
    }

    static function getFormat(string $name)
    {
        if(!self::hasFormat($name))
        {
            return false;
        }

        return self::$formats[$name];
    }

    static function hasFormat(string $name)
    {
        return isset(self::$formats[$name]);
    }

    static function getFormates()
    {
        return self::$formats;
    }

    function setMethod(string $method)
    {
        if(!$this->hasMethod($method))
        {
            throw new MethodNotFound($method);
        }

        $this->method = $method;
        return $this;
    }

    function setToken(string $token)
    {
        $this->token = $token;

        $this->generateDecrypt();
        $this->generateIv();

        return $this;
    }

    function loadFormat(string $format)
    {
        if(!$class = self::getFormat($format))
        {
            throw new FormatNotFound($format);
        }

        if(!class_exists($class))
        {
            throw new FormatClassNotFound($class);
        }

        $this->format = new $class($this);

        if(!$this->format instanceof FormatInterface)
        {
            throw new FormatTypeError($class);
        }

        return $this->format;
    }

    function getMethods(bool $aliases = false)
    {
        return openssl_get_cipher_methods($aliases);
    }

    function getMethod()
    {
        return $this->method;
    }

    function getToken()
    {
        return $this->token;
    }

    function getFormater()
    {
        return $this->format;
    }

    function getDecrypt()
    {
        return $this->decrypt;
    }

    function getIv()
    {
        return $this->iv;
    }

    function encode()
    {
        $data = (array) $this->getArray();
        $result = $this->format->encode($data);

        $result = openssl_encrypt($result,
            $this->getMethod(), $this->getDecrypt(),
            OPENSSL_RAW_DATA, $this->getIv()
        );

        if($result === false)
        {
            $error = error_get_last();
            throw new \Exception($error['message']);
        }

        return (string) base64_encode($result);
    }

    function decode(string $string)
    {
        $result = (string) base64_decode($string);

        $result = openssl_decrypt($result,
            $this->getMethod(), $this->getDecrypt(),
            OPENSSL_RAW_DATA, $this->getIv()
        );

        if($result === false)
        {
            $error = error_get_last();
            throw new \Exception($error['message']);
        }

        return $this->format->decode($result);
    }

    function hasMethod(string $method)
    {
        $methods = $this->getMethods(true);
        return in_array($method, $methods);
    }

    private function generateDecrypt()
    {
        $decrypt = substr($this->token, 3, 5);
        $decrypt .= substr($this->token, 7, 20);
        $decrypt .= substr($this->token, 15, 10);
        $decrypt .= substr($this->token, 10, 14);
        $decrypt .= substr($this->token, 17, 8);

        $this->decrypt = md5($this->token . $decrypt);
    }

    private function generateIv()
    {
        $this->iv = substr($this->token, 3, 5);
        $this->iv .= substr($this->token, 7, 3);
        $this->iv .= substr($this->token, 15, 4);
        $this->iv .= substr($this->token, 10, 2);
        $this->iv .= substr($this->token, 17, 2);
    }
}