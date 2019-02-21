<?php

require 'vendor/autoload.php';
require_once 'misc/Helper.php';
require 'controllers/Attendance.php';
require 'controllers/Auth.php';



$app = new \Slim\App();

/* ======== Endpoints ======== */


// Authentication endpoints
$app->post('/login', \AuthController::class . ':login' );
$app->post('/register', \AuthController::class . ':register' );

// Attendance endpoints
$app->get('/last_attendance/{user_id}', \AttendanceController::class . ':get_last_attendance_by_user_id');


/* ======== Endpoints ======== */





$app->run();