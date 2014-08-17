<?php
/**
 * Security utilities
 *
 * Adapted from https://github.com/soatok/furbb/tree/master/src/furbb
 */
abstract class Secure
{
    /**
     * Generate a cryptographically secure pseudorandom number
     * @param integer $bytes - Number of bytes needed
     * @return string
     */
    public static function random_bytes($bytes)
    {
        if (!is_int($bytes) || $bytes < 1) {
            throw new Exception("\$bytes must be a positive integer greater than zero.");
        }
        if (is_readable('/dev/urandom')) {
            $fp = fopen('/dev/urandom', 'rb');
            if ($fp !== false) {
                $buf = fread($fp, $bytes);
                fclose($fp);
                if ($buf !== false) {
                    // Sanity check:
                    if (strlen($buf) === $bytes) {
                        return $buf;
                    }
                }
            }
        }
        if (function_exists('mcrypt_create_iv') && defined('MCRYPT_DEV_URANDOM')) {
            // mcrypt handles Windows' lack of /dev/urandom with some sanity
            return mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($bytes);
        }
        throw new Exception("No suitable random number generator available.");
    }

    /**
     * Compare strings so that timing attacks are not feasible
     * @param string $a - hash
     * @param string $b - hash
     * @return boolean
     */
    public static function compare($a, $b)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        $diff = strlen($a) ^ strlen($b);
        for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
        {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
        /*
        // Alternative strategy
        $nonce = self::random(32);
        return hash_hmac('sha256', $a, $nonce) === hash_hmac('sha256', $b, $nonce);
        */
    }
}
