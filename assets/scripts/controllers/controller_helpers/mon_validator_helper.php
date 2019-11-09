<?php
    namespace app {        
        //Declarations
        use \helpers\Helper as _help;
        $errors = array();

        $HAS_VALID_FORM = false; //Refers both a form being submitted and valid

        $monNameEl = "monName";
        $monNameValue = "";
        $primeTypeEl = "primaryType";
        $primeTypeValue = 0;
        $secondTypeEl = "secondaryType";
        $secondTypeValue = 0;
        $bioEl = "bio";
        $bioValue = "";
        $imageEl = "profileImage";
        $new_image_id;

        $monNameMaxLength = 35;
        $bioMaxLength = 250;

        $oriNameValue = 'originalName';
        $validateAmendImage = false;

        //Validate data
        if (isset($_POST['createMonBTN']) || isset($_POST['amendMonBTN'])){
            $monNameValue =  ucfirst(trim(_help::FixMySQLString($conn, $_POST[$monNameEl])));
            $primeTypeValue = $_POST[$primeTypeEl];
            $secondTypeValue = $_POST[$secondTypeEl];

            //To keep the /r/n tags we can't use stripslashes or conn->real_escape_string for bio
            $bioValue = ucfirst(trim((htmlentities(strip_tags($_POST[$bioEl])))));

            if (isset($_POST['amendMonBTN']) && $_FILES[$imageEl]['error'] == 0){
                $validateAmendImage = true;
            }

            //Validate MonName
            if (empty($monNameValue)){
                $errors[$monNameEl] = "MonName is required";
            }
            else if (strlen($monNameValue) < 2 || strlen($monNameValue) > $monNameMaxLength){
                $errors[$monNameEl] = "MonName must be between 2 and $monNameMaxLength chars";
            }
            else if (preg_match("/[^A-Za-z0-9\-]/", $monNameValue)){
                $errors[$monNameEl] = "MonName is invalid"; //For now MySQLMon can have numbers and hypens
            }
            else if (isset($_POST['createMonBTN']) && _help::ExistsInDatabase($conn, "mons", "name", $monNameValue)){
                $errors[$monNameEl] = "MonName name is already taken";
            }
            else if (isset($_POST['amendMonBTN']) && _help::ExistsInDatabase($conn, "mons", "name", $monNameValue) && $monNameValue != $_SESSION[$oriNameValue]) {
                $errors[$monNameEl] = "Cannot rename $_SESSION[$oriNameValue] to $monNameValue as it ais already taken";
            }

            //Validate Types
            if ($primeTypeValue == 0){
                $errors[$primeTypeEl] = "Primary Type can't be None";
            }
            else if ($secondTypeValue == $primeTypeValue){
                $errors[$primeTypeEl] = "Secondary Type can't be same as Primary Type";
            }

            //Validate Bio
            if (empty($bioValue)){
                $errors[$bioEl] = "Bio is required";
            }
            else if (strlen($bioValue) > $bioMaxLength){
                $errors[$bioEl] = "Bio must only be $bioMaxLength characters long";
            }

            //Validate Image
            if (isset($_POST['createMonBTN']) || $validateAmendImage){
                if (empty($_FILES[$imageEl])){
                    $errors[$imageEl] = "Image is required";
                }
                else if ($_FILES[$imageEl]['error'] !== 0){
                    $errors[$imageEl] = "Upload Error: " . _help::$image_errors[$_FILES[$imageEl]['error']];
                }
                else if (!is_uploaded_file($_FILES[$imageEl]['tmp_name'])){
                    $errors[$imageEl] = "There was an upload error";
                }
                else if (!_help::FileIsImage($_FILES[$imageEl]['type'])){
                    $errors[$imageEl] = "File is not an image";
                }
            }

            if (count($errors) === 0){
                $HAS_VALID_FORM = true;
            }
        }
    }