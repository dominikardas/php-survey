<?php
    function dump($s) {
        echo '<pre>';
        var_dump($s);
        echo '</pre>';
        die();
    }
    
    function sanitize($input) {
        $sanitized = htmlentities($input, ENT_QUOTES, 'UTF-8');
        return $sanitized;
    }
?>