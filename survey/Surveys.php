<?php

    require_once('./db/Database.php');
    require_once('./lib/helpers/helpers.php');   


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
            // if ($this->_db->query($sql, $params)->resultLength() > 0) { die('You have already voted'); }

            // Check if the submitted option is valid
            if (!$this->isValidOption($survey, $option)) { die('Invalid option'); }

            // Submit the vote
            $sql = 'INSERT INTO Votes (survey_id, voted_option, user_ip) VALUES (:survey_id, :voted_option, :user_ip)';
            $params = [
                'survey_id' => $survey,
                'voted_option' => $option,
                'user_ip' => $ip
            ];
            $result = $this->_db->query($sql, $params)->hasFailed();
            dump($result);

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

    }

?>