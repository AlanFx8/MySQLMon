<?php
    namespace app {
        session_start();
        require_once '/../autoloader.php';
        require_once '/../conn/db.php';
        require_once 'controller_helpers/mon_validator_helper.php';

        ///IF NO ERRORS///
        if ($HAS_VALID_FORM){
            //Add image to database
            $image = $_FILES[$imageEl];
            $image_filename = $image['name'];
            $image_info = getimagesize($image['tmp_name']);
            $image_mime_type = $image_info['mime'];
            $image_size = $image['size'];
            $image_data = file_get_contents($image['tmp_name']);

            $escapedImgeFile = $conn->real_escape_string($image_filename);
            $escapedImageMimeType = $conn->real_escape_string($image_mime_type);
            $escapedImgeSize = $conn->real_escape_string($image_size);

            $query_string = "INSERT INTO mon_profile_images (filename, mime_type, file_size, image_data) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query_string);
            $stmt->bind_param('ssds', $escapedImgeFile, $escapedImageMimeType,
            $escapedImgeSize, $image_data);

            if ($stmt->execute()){
                $new_image_id = $conn->insert_id; //Get the image id
            }
            else {
                die("Sorry, there was an error uploading the image. Error: " . $conn->error);
            }

            //Add MySQLMon
            $query_string = "INSERT INTO mons (name, primary_type, secondary_type, bio, profile_image_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query_string);
            $stmt->bind_param('siisi', $monNameValue, $primeTypeValue, $secondTypeValue, $bioValue, $new_image_id);

            if ($stmt->execute()){
                $new_mon_id = $conn->insert_id; //Get the mon id
                //Set Session
                $_SESSION['title'] = "Created a MySQLMon";
                $_SESSION['message'] = "You created a MySQLMon!";
                $_SESSION['monID'] = $new_image_id;
                $_SESSION['monName'] = $monNameValue;
                $_SESSION['primeType'] = $primeTypeValue;
                $_SESSION['secondType'] = $secondTypeValue;
                $_SESSION['bio'] = $bioValue;
                $_SESSION['image_id'] = $new_image_id;
                $stmt->close();
                $conn->close();
                header('location: sub_pages/results.php');
                exit();
            }
        }
    }