<?php

/**
 * Copyright (c) 2021, Art of WiFi
 *
 * This file is subject to the MIT license that is bundled with this package in the file LICENSE.md
 */

/**
 * Controller configuration
 * ===============================
 * Copy this file to your working directory, rename it to config.php and update the section below with your UniFi
 * controller details and credentials
 */
$controlleruser     = 'user'; // the user name for access to the UniFi Controller
$controllerpassword = 'password'; // the password for access to the UniFi Controller
$controllerurl      = 'https://1.1.1.1:8443'; // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443', for UniFi OS-based
// controllers a port suffix isn't required, no trailing slashes should be added
$controllerversion  = '4.0.0'; // the version of the Controller software, e.g. '4.6.6' (must be at least 4.0.0)

/**
 * set to true (without quotes) to enable debug output to the browser and the PHP error log
 */
$debug = false;
