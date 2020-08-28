<?php

    error_reporting(0);
    ini_set('display_errors', 0);

    include_once __DIR__ . '\..\lib\helpers\helpers.php';   
    include_once __DIR__ . '\Surveys.php';

    $output = '';

    if(isset($_FILES['file']['name']) &&  $_FILES['file']['name'] != '') {

        $valid_extension = array('xml');
        $file_data = explode('.', $_FILES['file']['name']);
        $file_extension = end($file_data);

        if(in_array($file_extension, $valid_extension)) {

            $data = simplexml_load_file($_FILES['file']['tmp_name']);

            foreach ($data as $survey) {

                $question = (string)$survey->question;
                
                $options = [];
                foreach($survey->options->element as $option) {
                    $options[] = (array)$option;
                }
                $options = json_encode($options);

                $db = new Surveys();
                $db->createSurvey($question, $options);
            }

            $output = 'Data Initialized';
        }
        else {
            $output = 'Invalid File';
        }
    }
    else {
        $output = 'Please Select XML File';
    }

    echo $output;

?>