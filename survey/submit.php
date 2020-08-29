<?php
    /* Submit votes */

    session_start();

    error_reporting(0);
    ini_set('display_errors', 0);

    include_once __DIR__ . '\..\lib\helpers\helpers.php';
    include_once __DIR__ . '\Survey.php';

    $id = sanitize($_POST['survey_id']);

    if (!isset($_SESSION['voted_surveys']))         { $_SESSION['voted_surveys'] = array(); }
    if (!in_array($id, $_SESSION['voted_surveys'])) { $_SESSION['voted_surveys'][] = $id;   }

    $db = new Survey();
    $db->submitSurvey();
?>