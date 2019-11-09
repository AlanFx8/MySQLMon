<?php
    //Builds the form for creating MySQLMon
    namespace builders {
        class MonFormBuilder {
            //PUBLIC METHODS//
            //Action: create_mon, amend_mon etc.
            //Uniue ID for each form if needed
            //Name, txt: refers to name attribute and text of the submit button
            //TypeNames: (array) the element name for each type int taken from the MonData class
            //monNameValue etc. The default values of a MySQLMon so they don't get lost on re-load
            public static function BuildForm($action, $id, $name, $txt, $monNameValue, $typeNames, $secondTypeValue, $primeTypeValue, $bioValue){
                echo "<form action='$action.php' method='POST' enctype='multipart/form-data' id='$id' novalidate>\n";
                    echo self::_getMonName($monNameValue);
                    echo self::_getTypes($typeNames, $secondTypeValue, $primeTypeValue);
                    echo self::_getBio($bioValue);
                    echo self::_getProfileImage();
                    echo self::_getButton($name, $txt);
                echo "</form>\n";
            }

            //PRIVATE METHODS//
            private static function _getMonName($monNameValue){
                return
                "<div class='formSet'>
                    <input type='text' name='monName' id='monName' maxsize='35' value='$monNameValue' required />
                    <label for='monName'>Mon Name</label>
                </div>";
            }

            private static function _getTypes($typeNames, $secondTypeValue, $primeTypeValue){
                $start = "<div class='formSet'>";
                $secondSelect = self::_getTypeSelect("secondaryType", $typeNames, $secondTypeValue);
                $primeSelect = self::_getTypeSelect("primaryType", $typeNames, $primeTypeValue);
                $end = "<label>Types</label>\n</div>";
                return $start . $secondSelect . $primeSelect . $end;
            }

            private static function _getBio($bioValue){
                return
                "<div class='formSet'>
                    <textarea name='bio' id='bio' cols='30' rows='5' maxlength='250' placeholder='250 character limit...' required>$bioValue</textarea>
                    <label for='bio'>Bio</label>
                </div>";
            }

            private static function _getProfileImage(){
                return
                "<div class='formSet'>
                    <input type='file' name='profileImage' id='profileImage' size='30' />
                    <label for='profileImage'>Profile Image</label>
                </div>";
            }

            private static function _getButton($name, $txt){
                return
                    "<div class='formSet'>
                        <button type='submit' name='$name' id='$name'>$txt</button>
                    </div>";
            }

            //HELPER FUNCTIONS//
            private static function _getTypeSelect($name, $typeNames, $typeValue){
                $result = "<select name='$name' id='$name'>\n";
                for ($x = 0; $x < count($typeNames); $x++){
                    $selected = ($x == $typeValue)?"selected":"";
                    $result .= "<option value='$x' $selected>$typeNames[$x]</option>\n";
                }
                $result .= "</select>";
                return $result;
            }
        }
    }