<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    /** @var Google_CLient $googleClient */
    $googleClient = $this->get('google');

    if(!isset($_SESSION['accessToken']))
    {
        $oAuthUrl = $googleClient->createAuthUrl();
        // Render index view
        return $this->renderer->render($response, 'index.phtml', ['authUrl' => $oAuthUrl]);
    }

    $me = $this->get('me');

    return $this->renderer->render($response, 'home.phtml', ['me' => $me]);

});


$app->get('/auth', function($request, \Psr\Http\Message\ResponseInterface $response, $args) {
    $googleClient = $this->get('google');

    $googleClient->authenticate($_GET['code']);

    $_SESSION['accessToken'] = $googleClient->getAccessToken();

    header("Location: /");
});