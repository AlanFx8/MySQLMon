<?php
    //A helper class to list potential form errors
    namespace helpers {
        class Errors {
            public static function ListErrors($errors){
                if (count($errors) > 0){
                    echo "<div id='phpErrors'>\n";
                    foreach ($errors as $error){
                        echo "<div class='phpErrorMSG'>$error</div>\n";
                    }
                    echo "</div>\n";
                }
            }
        }
    }