<?php
/**
 * Created by PhpStorm.
 * User: Ramin
 * Date: 6/6/2017
 * Time: 8:52 AM
 */

namespace eigitallabs\ePaisa;
use \phpseclib\Crypt\TripleDES;

class Encrypt
{
    /**
     * 3-DES Encrypt in EDE-CBC3 Mode
     *
     * @param string $hexData
     *      Data in hexadecimal representation
     * @param string $hexKey
     *      Key in hexadecimal representation
     *
     * @param null $iv
     * @return string Encrypted data in hexadecimal representation
     * Encrypted data in hexadecimal representation
     */
    public static function encrypt($hexData, $hexKey, $iv = null)
    {
        //fix Crypt Library padding
        $hexKey = $hexKey . substr($hexKey, 0, 16);

        $crypt3DES = new TripleDES(TripleDES::MODE_CBC3);
        if ($iv !== null) {
            $crypt3DES->setIV($iv);
        }
        $crypt3DES->setKey($hexKey);
        $crypt3DES->disablePadding();

        return $crypt3DES->encrypt($hexData);
    }

    /**
     * 3-DES Decrypt in EDE-CBC3 Mode ePaisa SPL
     *
     * @param string $hexEncryptedData
     *      Encrypted Data in hexadecimal representation
     * @param string $hexKey
     *      Key in hexadecimal representation
     * @param null $iv
     * @param bool $useDesModeCBC3
     *      Use DES CBC3 Mode
     * @return string Decrypted data in hexadecimal representation
     * Decrypted data in hexadecimal representation
     */
    public static function decrypt($hexEncryptedData, $hexKey, $iv = null, $useDesModeCBC3 = false)
    {
        //fix Crypt Library padding
        $hexKey = $hexKey . substr($hexKey, 0, 16);

        if ($useDesModeCBC3) {
            $crypt3DES = new TripleDES(TripleDES::MODE_CBC3); // IDTech uses mode TripleDES::MODE_CBC3
        } else {
            $crypt3DES = new TripleDES(TripleDES::MODE_ECB); // Chinese uses mode TripleDES::MODE_ECB
        }
        if ($iv !== null) {
            $crypt3DES->setIV($iv);
        }
        $crypt3DES->setKey($hexKey);
        $crypt3DES->disablePadding();

        return strtoupper(bin2hex($crypt3DES->decrypt($hexEncryptedData)));
    }
}