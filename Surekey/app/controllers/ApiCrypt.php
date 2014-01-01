<?php
/**
 * Created by PhpStorm.
 * User: Xpl0ze
 * Date: 26/12/13
 * Time: 18:15
 */
class ApiCrypt extends BaseController
{

    public static function encrypt($str, $key) {

        $iv  = 'fdsfds85435nfdfs'; #Same as in JAVA
        $str = ApiCrypt::pkcs5_pad($str);
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
        mcrypt_generic_init($td, $key, $iv);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return bin2hex($encrypted);
    }

    public static function decrypt($str, $key) {

        $iv  = 'fdsfds85435nfdfs'; #Same as in JAVA
        $str = ApiCrypt::hex2bin($str);
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
        mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $ut =  utf8_encode(trim($decrypted));
        return $ut;
        //return ApiCrypt::pkcs5_unpad($ut);
    }

    private static function hex2bin($hexdata) {
        $bindata = '';
        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }

    private static function pkcs5_pad ($text) {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private static function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
}