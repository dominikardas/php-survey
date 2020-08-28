<?php

    include_once __DIR__ . '\lib\helpers\helpers.php';   
    include_once __DIR__ . '\survey\Surveys.php';

    $db = new Surveys();
    $surveys = $db->getAllSurveys();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>    
    <script type="text/javascript" src="js/script.js"></script>
    <title>Survey</title>
</head>
<body>

    <div class="c-container">
    
        
        <?php
            foreach ($surveys as $survey) { 
                $survey = (array)($survey); 
        ?>
            <form class="js-form l-form" method="post" action="survey/submit">
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
                                $name = 'survey_' . $survey['id'];
                                $results = $db->getVotesByOption($survey['id'], $option['id']);
                        ?>
                            <div class="l-survey-option">
                                <div class="l-option_input">
                                    <input type="radio" name="<?= $name ?>" id="<?= $id ?>" value="<?= $option['id'] ?>" />
                                    <label for="<?= $id ?>"><?= $option['option'] ?></label>
                                </div>
                                <div class="l-option_votes">
                                    <p class="l-votes"><?= $results['votesPercentage']; ?>% (<?= $results['votes']; ?> votes)</p>
                                    <div class="l-survey_percentage" style="width:<?= $results['votesPercentage'] ?>%"></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <input type="submit" class="btn btn-submit" placeholder="Submit" />
                    <p class="l-resp"></p>
                </div>
            </form>
        <?php } ?>
        
        <form class="js-file-form l-form" method="post" enctype="multipart/form-data" action="survey/create">
            <div class="l-survey l-survey_new">
                <span>Select XML file to upload</span>
                <input type="file" name="file" id="file">
                <input type="submit" class="btn btn-submit" value="Upload" name="submit">
                <p class="l-resp"></p>
            </div>
        </form>
    </div>
</body>
</html>