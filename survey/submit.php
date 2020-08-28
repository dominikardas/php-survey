<?php

    error_reporting(0);
    ini_set('display_errors', 0);

    include_once __DIR__ . '\..\lib\helpers\helpers.php';
    include_once __DIR__ . '\Surveys.php';

    $db = new Surveys();
    $db->submitSurvey();
?>