<?php
    //A helper class that deals with handling ID requests
    //Due to show_mon.php we need to use REQUEST instead of GET
    namespace app {
        class MonIDRequest {
            public static function GetRequest($conn){
                if (!isset($_REQUEST['id']))
                    return false;
                        
                if (empty($_REQUEST['id'])){
                    echo "Error: the value for ID is empty";
                    return false;
                }
                
                if (!is_numeric($_REQUEST['id'])){
                    echo "Error: ID value is not a number";
                    return false;
                }

                $id = $_REQUEST['id'];
                $query_string = "SELECT * FROM mons WHERE id=$id LIMIT 1";
                $result = $conn->query($query_string) or die("Fatal error: " . $conn->error);

                if ($result){
                    if ($result->num_rows === 0){
                        echo "Sorry, $id returned no result.";
                        return false;
                    }
                }
                return $result;
            }
        }
    }