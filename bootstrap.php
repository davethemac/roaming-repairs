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
// are we testing
if($_ENV['APP_ENV']==='testing'){ // INPUT_ENV not working
    $loader->add('App', ROOT.'/test/phpunit');
} //*/
/* are we testing ?
if(filter_input(INPUT_ENV, 'APP_ENV', FILTER_SANITIZE_STRING)==='testing'){
    // add the app test folder
    $loader->add('App', ROOT.'/test/phpunit');
}
// */