<?php
    //Builds the select and sort buttton for the MySQLMon
    //Due to show_mon.php we need to use REQUEST instead of GET
    namespace builders {
        class MonNavBuilder {
            //PUBLIC METHODS//
            public static function BuildNavigation($conn, $monTypeColor){
                //Order
                if (isset($_REQUEST['order'])){
                    if ($_SESSION['order'] != $_REQUEST['order']){
                        $_SESSION['type'] = "DESC";
                    }
                    $_SESSION['order'] = $_REQUEST['order'];
                }
                else if (empty($_SESSION['order'])){
                    $_SESSION['order'] = "id";
                }

                //Type
                if (empty($_SESSION['type'])){
                    $_SESSION['type'] = "ASC";
                }
                else if (empty($_REQUEST['id'])) {
                    $_SESSION['type'] = ($_SESSION['type'] == "ASC")?"DESC":"ASC";
                }

                //Build Buttons
                echo "<div id='monBTNWrapper'>";
                self::_buildSortButtons();
                self::_buildMonButtons($conn, $monTypeColor, $_SESSION['order'], $_SESSION['type']);
                echo "</div>";
            }

            //PRIVATE METHODS//
            private static function _buildSortButtons(){
                echo "<div id='orderBTNWrapper'>\n";
                    echo "<a href='?order=id' class='orderBTN'>ID</a>\n";
                    echo "<a href='?order=name' class='orderBTN'>Name</a>\n";
                    echo "<a href='?order=primary_type' class='orderBTN'>Type</a>\n";
                echo "</div>\n";
            }

            private static function _buildMonButtons($conn, $monTypeColor, $orderType, $sortType){
                $query_string = "SELECT id, name, primary_type FROM mons ORDER BY $orderType $sortType";
                $result = $conn->query($query_string) or die("Fatal error: " . $conn->error);
                if ($result){
                    $noOfMySQLMon = $result->num_rows;
                    if ($noOfMySQLMon === 0){
                        echo "Sorry there was an error getting the MySQLMon.";
                    }
                    else {
                        for ($x = 0; $x < $noOfMySQLMon; $x++){
                            $result->data_seek($x);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $instanceID = $row['id'];
                            $instanceName = $row['name'];
                            $typeColor = $monTypeColor[$row['primary_type']];
                            echo "<a href='?id=$instanceID' class='getMonBTN' style='background-color:$typeColor' />$instanceName</a>";
                        }
                    }
                }
            }
        }
    }