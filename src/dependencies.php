<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $logger = new Monolog\Logger($c->get('settings')['appName']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler(fopen('php://stdout', 'w')));
    return $logger;
};

$container['google'] = function($c) {
    $client = new Google_Client();
    $client->setApplicationName($c->get('settings')['appName']);
    $client->setAuthConfig($c->get('settings')['google']);

    $client->setIncludeGrantedScopes(true);   // incremental auth
//    $client->addScope(Google_Service_Plus::PLUS_ME);
    $client->addScope(Google_Service_Plus::USERINFO_EMAIL);
    $client->setRedirectUri($c->get('settings')['google']['redirect_uri']);

    return $client;
};

$container['googlePlus'] = function($c) {

    $client = $c->get('google');

    $client->setAccessToken($_SESSION['accessToken']);

    $plus = new Google_Service_Plus($client);

    return $plus;
};

$container['me'] = function($c) {
    $plus = $c->get('googlePlus');

    /** @var Google_Service_Plus_Person $me */
    $me = $plus->people->get("me");

    $emails = $me->getEmails();

    /** @var Google_Service_Plus_PersonEmails $firstEmail */
    $firstEmail = $emails[0];

    return $firstEmail->getValue();
};