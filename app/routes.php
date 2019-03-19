<?php

use app\controllers\IdeasController;

/** @var \app\Application $app */
$app->get('/api/ideas', IdeasController::class . ':view');
$app->post('/api/ideas', IdeasController::class . ':create');

$app->post('/api/like', IdeasController::class . ':like');
$app->post('/api/dislike', IdeasController::class . ':dislike');
