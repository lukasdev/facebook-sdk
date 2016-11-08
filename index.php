<?php
    date_default_timezone_set("America/Sao_Paulo");
    include 'vendor/autoload.php';

    $page_id = '{id_da_sua_pagina}';
    $app_id = '{seu_app_id}';
    $app_secret = '{seu_app_secret}';

    $fb = new \Facebook\Facebook([
        'app_id' => $app_id,
        'app_secret' => $app_secret
    ]);

    $expires = time()+(60*60)*2;
    $fbAt = new \Facebook\Authentication\AccessToken($app_id.'|'.$app_secret, $expires);
    $token = (string)$fbAt;

    $fb->setDefaultAccessToken($token);

    $fields = 'id,name,description,place,start_time,cover';
    $request = $fb->request('GET', '/'.$page_id.'/events?fields='.$fields);
    $response = $fb->getClient()->sendRequest($request);

    $body = $response->getBody();
    $obj = json_decode($body);

    $eventos = $obj->data;

    foreach ($eventos as $evento) {
        echo '<img src="'.$evento->cover->source.'" width="300" />';
        echo '<h2>'.$evento->name.'</h2>';
        echo '<p>'.date('d/m/Y H:i', strtotime($evento->start_time)).'</p>';
    }
