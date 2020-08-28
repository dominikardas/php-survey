<?php

    include_once __DIR__ . '\..\db\Database.php';
    include_once __DIR__ . '\..\lib\helpers\helpers.php';   

    class Surveys {

        private $_db;

        public function __construct() {
            $this->_db = Database::getInstance();
        }

        public function getAllSurveys() {

            $sql = "SELECT * FROM Surveys";
            $data = $this->_db->query($sql)->results();
            return $data;
        }

        public function getAllVotes() {

            $sql = "SELECT * FROM Votes";
            $data = $this->_db->query($sql)->results();
            return $data;
        }

        public function vote($survey, $option) {

            // Get IP of the user
            $ip = $_SERVER['REMOTE_ADDR'];

            // Check if the user hasn't already voted
            $sql = "SELECT * FROM Votes WHERE survey_id=:survey_id AND user_ip=:user_ip";
            $params = [
                'survey_id' => $survey,
                'user_ip' => $ip
            ];
            if ($this->_db->query($sql, $params)->resultLength() > 0) { return 'ERR_HAS_VOTED'; }

            // Check if the submitted option is valid
            if (!$this->isValidOption($survey, $option)) { return 'ERR_INVALID_OPTION'; }

            // Submit the vote
            $sql = 'INSERT INTO Votes (survey_id, voted_option, user_ip) VALUES (:survey_id, :voted_option, :user_ip)';
            $params = [
                'survey_id' => $survey,
                'voted_option' => $option,
                'user_ip' => $ip
            ];
            
            return !$this->_db->query($sql, $params)->hasFailed();
        }

        public function isValidOption($survey, $option) {

            // Set up the query
            $sql = "SELECT * FROM Surveys WHERE id=:id";
            $params = [ 'id' => $survey ];

            // If the submitted survey is valid
            if ($this->_db->query($sql, $params)->results()) {

                // Get the result
                $survey = $this->_db->resultsFirst();

                // Decode the options
                $options = $survey['options'];
                $options = json_decode($options, true);

                // Check if the selected option is valid
                foreach ($options as $item) {
                    if (isset($item['id']) && $item['id'] == $option) {
                        return true;
                    }
                }
            }

            return false;
        }

        public function submitSurvey() {        
    
            $survey = sanitize($_POST['survey_id']);
            $option = sanitize($_POST['survey_' . $survey]);
    
            $result = $this->vote($survey, $option);
    
            switch (true) {
                case $result === true:
                    echo 'Your vote has been submitted';
                    break;
                case $result === false:
                    echo 'There was an error';
                    break;
                case $result === 'ERR_HAS_VOTED':
                    echo 'You have already voted';
                    break;
                case $result === 'ERR_INVALID_OPTION':
                    echo 'The selected option is not valid';
                    break;
                default:
                    break;
            }
        }

    }

?>