<?php
    /* Initialize a new survey from XML file */

    error_reporting(0);
    ini_set('display_errors', 0);
    libxml_use_internal_errors(true);

    include_once __DIR__ . '\..\lib\helpers\helpers.php';   
    include_once __DIR__ . '\Survey.php';

    $output = '';

    if(isset($_FILES['file']['name']) &&  $_FILES['file']['name'] != '') {

        $valid_extension = array('xml');
        $file_data = explode('.', $_FILES['file']['name']);
        $file_extension = end($file_data);

        // Check if the submitted file is an XML file
        if(in_array($file_extension, $valid_extension)) {

            // Load the XML
            $data = simplexml_load_file($_FILES['file']['tmp_name']);

            // Die if the file is invalid
            if ($data === false) {
                echo "Failed loading XML<br><br>";
                foreach(libxml_get_errors() as $error) {
                    echo "\t" . $error->message . "<br><br>";
                }
                die();
            }

            // Get the data
            foreach ($data as $survey) {

                // Get the question and options
                $question = (string)$survey->question;                
                $options = [];
                foreach($survey->options->element as $option) {
                    $options[] = (array)$option;
                }
                // Encode the options into JSON
                $options = json_encode($options);

                // Handle errors, otherwise create the survey
                if      (!isset($question) || empty($question))  { die('Invalid File Structure - Question is not set'); }
                else if (!isset($options)  || $options === '[]') { die('Invalid File Structure - Options are not set'); }
                else {
                    $output = 'Data Initialized';
                    $db = new Survey();
                    $db->createSurvey($question, $options);
                }
            }
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