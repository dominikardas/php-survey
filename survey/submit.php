<?php
    /* Submit votes */

    session_start();

    error_reporting(0);
    ini_set('display_errors', 0);

    include_once __DIR__ . '\..\lib\helpers\helpers.php';
    include_once __DIR__ . '\Survey.php';

    if (!isset($_SESSION['voted_surveys'])) { $_SESSION['voted_surveys'] = array(); }

    $id = sanitize($_POST['survey_id']);
    $db = new Survey();

    if ($db->submitSurvey()) {
        if (!in_array($id, $_SESSION['voted_surveys'])) { $_SESSION['voted_surveys'][] = $id;   }        
    }
?>