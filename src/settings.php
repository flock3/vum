<?php

$debug = filter_var(getenv("DEBUG"), FILTER_VALIDATE_BOOLEAN);

$googleClientId = getenv("GOOGLE_CLIENT_ID");
$googleSecretKey = getenv("GOOGLE_SECRET_KEY");
$googleRedirectUri = getenv("GOOGLE_REDIRECT_URI");

return [
    'settings' => [
        'appName' => 'VUM',
        'displayErrorDetails' => $debug, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'level' => $debug ? Monolog\Logger::DEBUG : Monolog\Logger::INFO,
        ],

        'google' => [
            'client_id' => $googleClientId,
            'client_secret' => $googleSecretKey,
            'redirect_uri' => $googleRedirectUri,
        ]
    ],
];
