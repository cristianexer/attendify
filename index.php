<?php

require 'vendor/autoload.php';
require 'controllers/Attendance.php';
require 'controllers/Auth.php';
require 'middlewares/AuthMiddleware.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

/* ======== Endpoints ======== */


// Authentication endpoints

$app->post('/login', \AuthController::class . ':login' );
$app->post('/register', \AuthController::class . ':register' );



// Attendance endpoints

$app->get('/attendance/student/{student_id}', \AttendanceController::class . ':get')->add(new AuthMiddleware());
$app->post('/attendance/create', \AttendanceController::class . ':create')->add(new AuthMiddleware());


/* ======== Endpoints ======== */





$app->run();
