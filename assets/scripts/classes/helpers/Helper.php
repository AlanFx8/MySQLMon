<?php
    //A clollection of simple helper assets
    namespace helpers {
        class Helper {
            public static function FixMySQLString($conn, $var){
                $var = $conn->real_escape_string($var);
                return self::_fixString($var);
            }

            public static function ExistsInDatabase($conn, $table, $field, $value){
                $query = "SELECT * FROM $table WHERE $field=? LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $value);
                $stmt->execute();
                $result = $stmt->get_result();
                $userCount = $result->num_rows;
                $stmt->close();
        
                if ($userCount > 0){
                    return true;
                }
        
                return false;
            }

            public static $image_errors = array(
                1 => 'Maximum file size in php.ini exceeded',
                2 => 'Maximum file size in HTML form exceeded',
                3 => 'Only part of the file was uploaded',
                4 => 'No file was selected to upload'
            );

            //Note: this is a very simple method that doesn't check for x-png etc.
            public static function FileIsImage($fileType){
                switch($fileType){
                    case 'image/jpeg':
                    case 'image/gif':
                    case 'image/png':
                        return true;
                }
                return false;
            }

            private static function _fixString($var){
                return stripslashes(htmlentities(strip_tags($var)));
            }
        }
    }