<?php
/**
 * This file is part of the epaisa-php-sdk package.
 *
 * (c) Ramin Farmani <ramin.farmani@eigital.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/*
 * Set error reporting to the max level.
 */
error_reporting(-1);
/*
 * Set UTC timezone.
 */
date_default_timezone_set('UTC');
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$autoloader = __DIR__ . '/../vendor/autoload.php';

/*
 * Check that composer installation was done.
 */
if (!file_exists($autoloader)) {
    throw new Exception(
        'Please run "composer install" in root directory to setup unit test dependencies before running the tests'
    );
}
// Include the Composer autoloader.
require_once $autoloader;
/*
 * Unset global variables that are no longer needed.
 */
unset($autoloader);