<?php

use app\controllers\HelloController;

/** @var \app\Application $app */
$app->get('/hello', HelloController::class . ':index');
$app->post('/hello', HelloController::class . ':post');
