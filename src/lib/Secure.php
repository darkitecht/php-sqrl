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
            throw new Exception("\$bytes must be a positive integer greater than zero.");
            return false;
        }
        if (function_exists('\mcrypt_create_iv')) {
            return mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
        }
        return openssl_random_pseudo_bytes($bytes);
    }

    /**
     * Get a cryptographically secure random integer within a given range
     *
     * @param int $min - minimum value
     * @param int $max - maximum value
     */
    public static function random_int($min, $max) {
        if ($max <= $min) {
            throw new Exception("Invalid parameters passed to random_int()");
        }

        $rval = 0;
        $range = $max - $min;

        $need_bits = ceil(log($range, 2));

        // Create a bitmask
        $mask = intval( pow(2, $need_bits) - 1); // 7776 -> 8191

        // Number of random bytes to fetch
        $need_bytes = ceil($need_bits / 8);

        // Let's grab a random byte that falls within our range
        do {
            $rval = intval(self::random($need_bytes) & $mask);
        } while($rval> $range);
        // We now have a random value in the range between $min and $max, so...

        // Let's return the random value + the minimum value
        return $rval + $min;
    }

    /**
     * Compare strings so that timing attacks are not feasible
     * @param string $a - hash
     * @param string $b - hash
     * @return boolean
     */
    public static function compare($a, $b)
    {
        static $he = function_exists('hash_equals');
        if ($he) {
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
