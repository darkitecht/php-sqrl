<?php
/**
 * (optional) -- polyfills libsodium if the Sodium extension is not installed
 */

if (!class_exists('Sodium')) {
    require __DIR__."/Salt/autoload.php";

    class Sodium extends Salt
    {
        // That'll do, pig. That'll do.
    }
}
