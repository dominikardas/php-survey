<?php

    require_once('lib/helpers/helpers.php');   
    require_once('survey/Surveys.php');

    $db = new Surveys();
    $surveys = $db->getAllSurveys();
    $votes = $db->getAllVotes();
    $db->vote(3, 2);
    // dump($db->isValidOption(2, 1));
    // dump($_SERVER['REMOTE_ADDR']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Survey</title>
</head>
<body>

    <div class="c-container">
    
        
        <?php
            foreach ($surveys as $survey) { 
                $survey = (array)($survey); 
        ?>
            <form class="l-form" method="post" action="survey/submit_survey.php">
                <div class="l-survey">
                    <input type="hidden" name="survey_id" value="<?= $survey['id'] ?>" />
                    <div class="l-survey_question">
                        <span><?= $survey['question'] ?></span>
                    </div>
                    <div class="l-survey_options">
                        <?php 
                            $options = json_decode($survey['options'], true);
                            foreach($options as $option) {
                                $id = rand();
                                $name = 'question_' . $survey['id'];
                        ?>
                            <div class="l-survey-option">
                                <input type="radio" name="<?= $name ?>" id="<?= $id ?>" value="<?= $option['id'] ?>" />
                                <label for="<?= $id ?>"><?= $option['option'] ?></label>
                            </div>
                        <?php } ?>
                    </div>
                    <input type="submit" class="btn btn-submit" placeholder="Submit" />
                </div>
            </form>
        <?php } ?>
    </div>
    
</body>
</html>