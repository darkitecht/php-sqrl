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
    public static function random($bytes)
    {
        if (!is_int($bytes) || $bytes < 1) {
            trigger_error("\$bytes must be a positive integer greater than zero.");
            return false;
        }
        if (function_exists('\mcrypt_create_iv')) {
            return mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
        }
        return openssl_random_pseudo_bytes($bytes);
    }

    /**
     * Compare strings so that timing attacks are not feasible
     * @param string $a - hash
     * @param string $b - hash
     * @return boolean
     */
    public static function compare($a, $b)
    {
        $nonce = self::random(32);
        return hash_hmac('sha256', $a, $nonce) === hash_hmac('sha256', $b, $nonce);
    }

    /**
     * Wrapper for htmlentities()
     *
     * @param string $untrusted
     * @return string
     */
    public static function noHTML($untrusted)
    {
        return htmlentities($untrusted, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
