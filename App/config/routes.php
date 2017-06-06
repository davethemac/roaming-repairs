<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$app->get('/', 'App\Controller\JobController::job'); // altered for demo
$app->post('/', 'App\Controller\JobController::post'); // altered for demo
$app->get('/test/', 'App\Controller\IndexController::test');

$app->get('/login', 'App\Controller\UserController::login');

// jobs
$app->get('/jobs', 'App\Controller\JobController::index');
$app->get('/jobs/{id}', 'App\Controller\JobController::job');
$app->post('/jobs/{id}', 'App\Controller\JobController::post');

//$app->get('/test', 'App\Controller\JobController::altForm');
// parts
$app->get('/parts', 'App\Controller\PartController::index');

// pdf
$app->get('/pdf', 'App\Controller\PDFController::job');
$app->get('/pdf/{id}', 'App\Controller\PDFController::job');