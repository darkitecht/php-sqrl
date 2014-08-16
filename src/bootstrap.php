<?php

require_once __DIR__."/lib/Secure.php";

if (!class_exists('Sodium')) {
    // I find your lack of `pecl install sodium` distrubing
    require_once __DIR__."/lib/sodium_compat.php";
}
require_once __DIR__."/lib/Pbkdf2.php";
require_once __DIR__."/lib/Scrypt.php";

require_once __DIR__."/lib/SQRL.php";
