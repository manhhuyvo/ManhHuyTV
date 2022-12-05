<?php

class ErrorMessage {
    public static function showError ($text){
        exit ("<span class='error-banner'> $text </span>");
    }
}

?>