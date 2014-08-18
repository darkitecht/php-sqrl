<?php

abstract class SQRL
{
    /**
     * Does the signature match the expected value, given a public key / challenge URI?
     *
     * @param string $full_challenge - www.example.com/sqrl?base64junk
     * @param string $public_key - user's Ed25519 public key
     * @param string $signature - Ed25519 signature
     * @return string
     */
    public static function authenticate(
        $full_challenge,
        $public_key,
        $signature
    ) {
        /**
        * @todo - Data transformation logic here, make sure this will work as intended
        */
        return Sodium::sign_verify($full_challenge, $signature, $public_key, 'sha512');
    }
    /**
     * Generate a cryptographic challenge string
     *
     * @param boolean $encode - Base64-encode the result?
     * @return string
     */
    public static function getChallengeString($encode = false)
    {
        $challenge = Secure::random_bytes(32);
        if($encode) {
            return base64_encode($challenge);
        }
        return $challenge;
    }

    public static function getChallengeQRCode(
        $string = null,
        $size = 300,
        $padding = 10
    ) {
        static $qrCode = null;
        if (empty($qrCode)) {
            $qrCode = new Endroid\QrCode\QrCode();
        }
        if (empty($string)) {
            $string = self::getChallengeString(true);
        }
        $qrCode->setText($string);
        $qrCode->setSize($size);
        $qrCode->setPadding($padding);
        return $qrcode->render();
    }
}
