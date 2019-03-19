<?php

use app\controllers\IdeasController;

/** @var \app\Application $app */
$app->get('/ideas', IdeasController::class . ':view');
$app->post('/ideas', IdeasController::class . ':create');

$app->post('/like', IdeasController::class . ':like');
$app->post('/dislike', IdeasController::class . ':dislike');
