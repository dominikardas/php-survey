<?php

    require_once('config.php');

    class Database {

        private static $_instance = null;        
        private $_pdo, $_query, $_error = false, $_result;

        private function __construct() {

            $dsn  = sprintf('mysql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);

            try {
                $this->_pdo = new PDO($dsn, DB_USER, DB_PASS);
                $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            }
            catch (PDOException $e) {
                die('PDO Error: ' . $e->getMessage());
            }
        }

        public static function getInstance() {

            if (!isset(self::$_instance)) {
                self::$_instance = new Database();
            }

            return self::$_instance;
        }

        /**
         * Process SQL Query
         * @param string $sql    - SQL Query as String
         * @param array  $params - SQL Params as Dictionary
         * 
         * @return object Database object
         */

        public function query($sql, $params = []) {

            $this->_error = false;
            $this->_result = null;

            // $stmt = $this->_pdo->prepare($sql);

            if ($this->_query = $this->_pdo->prepare($sql)) {
                if ($this->_query->execute($params)){
                    $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                }
                else {
                    $this->_error = true;
                }
            }

            return $this;
        }

        /**
         * Return all results
         * 
         * @return object Database result if not null, otherwise false
         */
        public function results() {
            return ((array)$this->_result == null) ? false : (array)$this->_result;
        }             

        /**
         * Return first results
         * 
         * @return object First database result if not null, otherwise false
         */
        public function resultsFirst() {
            return ((array)$this->results()[0] == null) ? false : (array)$this->results()[0];
        }

        /** 
         * Returns if the query has failed or not
         * 
         * @return boolean
         */
        public function hasFailed() {
            return $this->_error;
        }

        /** 
         * Returns the length of the result
         * 
         * @return int Length
         */
        public function resultLength() {
            return count($this->_result);
        }

    }

?>