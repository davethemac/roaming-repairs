<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// no real reason to put this here, apart from it being handy
define('ROOT', __DIR__);
// set timezone to avoid date problems
date_default_timezone_set('Europe/London');
// get composer autoload
$loader = require ROOT.'/vendor/autoload.php';
// add the app folder
$loader->add('App', ROOT);