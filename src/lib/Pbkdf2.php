<?php
/**
* Zend Framework (http://framework.zend.com/)
*
* @link http://github.com/zendframework/zf2 for the canonical source repository
* @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
* @license http://framework.zend.com/license/new-bsd New BSD License
*/

/**
* PKCS #5 v2.0 standard RFC 2898
*/
class Pbkdf2
{
    /**
    * Generate the new key
    *
    * @param string $hash The hash algorithm to be used by HMAC
    * @param string $password The source password/key
    * @param string $salt
    * @param int $iterations The number of iterations
    * @param int $length The output size
    * @throws Exception\InvalidArgumentException
    * @return string
    */
    public static function calc($hash, $password, $salt, $iterations, $length)
    {
        if (!Hmac::isSupported($hash)) {
            throw new Exception\InvalidArgumentException("The hash algorithm $hash is not supported by " . __CLASS__);
        }
        $num = ceil($length / strlen(hash($hash, 'data', true)));
        $result = '';
        for ($block = 1; $block <= $num; ++$block) {
            $hmac = hash_hmac($hash, $salt . pack('N', $block), $password, true);
            $mix = $hmac;
            for ($i = 1; $i < $iterations; ++$i) {
                $hmac = hash_hmac($hash, $hmac, $password, true);
                $mix ^= $hmac;
            }
            $result .= $mix;
        }
        return substr($result, 0, $length);
    }
}
