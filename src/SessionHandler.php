<?php

namespace eigitallabs\ePaisa;

/**
 * Created by PhpStorm.
 * User: Ramin
 * Date: 04/05/2017
 * Time: 09:25 AM
 */
class SessionHandler extends \SessionHandler
{
    protected $key, $name, $cookie;

    public function __construct($key, $name = 'EPAISA_SESSION', $cookie = [])
    {
        if (!extension_loaded('openssl')) {
            throw new \RuntimeException(sprintf(
                "You need the OpenSSL extension to use %s",
                __CLASS__
            ));
        }
        if (!extension_loaded('mbstring')) {
            throw new \RuntimeException(sprintf(
                "You need the Multibytes extension to use %s",
                __CLASS__
            ));
        }

        $this->key = substr(hash('sha256', $key), 0, 32);
        $this->name = $name;
        $this->cookie = $cookie;
        $this->cookie += [
            'lifetime' => 3600,
            'path'     => ini_get('session.cookie_path'),
            'domain'   => ini_get('session.cookie_domain'),
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true,
        ];
        $this->setup();
    }

    private function setup()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        session_name($this->name);
        session_set_cookie_params(
            $this->cookie['lifetime'],
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    public function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Make sure the session hasn't expired, and destroy it if it has
        if (self::validateSession()) {
            // Check to see if the session is new or a hijacking attempt
            if (!self::preventHijacking()) {
                // Reset session data and regenerate id
                $_SESSION = [];
                $_SESSION['ipAddress'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
                $_SESSION['userAgent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'CLI';
                self::regenerateSession();

                // Give a 5% chance of the session id changing on any request
            } elseif (rand(1, 100) <= 10) {
                self::regenerateSession();
            }
        } else {
            $_SESSION = [];
            session_destroy();
            session_start();
        }
    }

    public function read($id)
    {
        return (string)openssl_decrypt(parent::read($id), "aes-256-cbc", $this->key, 1, substr(md5($id), 0, 16));
    }

    public function write($id, $data)
    {
        return parent::write($id, openssl_encrypt($data, "aes-256-cbc", $this->key, 1, substr(md5($id), 0, 16)));
    }

    static protected function validateSession()
    {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])) {
            return false;
        }

        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()) {
            return false;
        }

        return true;
    }

    static function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true) {
            return;
        }

        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;

        if (isset($_SESSION['authKey_created_at'])) {
            $newLifeTime = 3600 - time() + $_SESSION['authKey_created_at'];
            if ($newLifeTime > 0) {
                $cookieParam = session_get_cookie_params();
                $cookieParam['lifetime'] = $newLifeTime;

                session_set_cookie_params($cookieParam['lifetime'], $cookieParam['path'], $cookieParam['domain'],
                    $cookieParam['secure'], $cookieParam['httponly']);
            } else {
                self::sessionEnd();
            }
        }
        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    static protected function preventHijacking()
    {
        if (!isset($_SESSION['ipAddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }

        if (isset($_SERVER['REMOTE_ADDR']) && $_SESSION['ipAddress'] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        if (isset($_SERVER['HTTP_USER_AGENT']) && $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    public function sessionEnd()
    {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $mainCookies = explode('=', $cookie);
                $name = trim($mainCookies[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
        $_SESSION = [];

        session_destroy();
        session_start();
    }
}