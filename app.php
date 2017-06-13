<?php

$app = new Silex\Application();
// this is where config vars should get set, possibly in an included file
$app['debug'] = true;
$smpt_settings = [
        'host' => '127.0.0.1',
        'port' => '1025',
        'username' => null,
        'password' => null,
        'encryption' => null,
        'auth_mode' => null
    ];

// set up PDO
$app['db'] = function($app){
        $dns = 'mysql:dbname=rr_jobs;host=localhost';
        $db_user = 'root';
        $db_pw = 'jacobite';
    try {
        $con = new PDO($dns,$db_user,$db_pw);
        if($app['debug']){
            $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $con;
    } catch (\PDOException $ex) {
        echo 'Could not connect to database: ' . $ex->getMessage();
    }
};

// services
$app['model.users'] = function ($app) {
    // bit clunky having the tablename here, sure there is some better config type way
    return new App\Service\UserService($app['db'], 'rr_user');
};
$app['model.customers'] = function ($app) {
    return new App\Service\CustomerService($app['db'], 'rr_customer');
};
$app['model.workers'] = function ($app) {
    return new App\Service\WorkerService($app['db'], 'rr_worker');
};
$app['model.parts'] = function ($app) {
    return new App\Service\PartService($app['db'], 'rr_part');
};
$app['model.partsused'] = function ($app) {
    return new App\Service\PartUsedService($app['db'], [
        'table' => 'rr_partused',
        'join' => 'rr_part',
        'foreign_key' => 'part_id',
        'references' => 'id'
    ], $app['model.parts']);
};
$app['model.jobs'] = function ($app) {
    return new App\Service\JobService($app['db'], 'rr_job', $app['model.partsused'], $app['model.workers']);
};

// service providers
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => ROOT.'/App/view',
    'twig.form.templates' => array('bootstrap_3_layout.html.twig'),
    'twig.options' => array(
        'debug' => true,
        'auto_reload' => true,
    )
));
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\CsrfServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array('pattern' => '^/login$'),
        'secured' => array(
            'pattern' => '^.*$',
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'logout' => array('logout_path' => '/logout', 'invalidate_session' => true),
            'users' => $app['model.users'],
            ),
        ),
    )
);

$app['model.users']->setEncoder($app['security.default_encoder']);

$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = $smpt_settings;


require ROOT.'/App/config/routes.php';

return $app;