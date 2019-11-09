<?php
    namespace app {
        session_start();
        require_once '/../autoloader.php';
        require_once '/../conn/db.php';
        require_once 'controller_helpers/mon_validator_helper.php';

        //Check if we can update a MySQLMon
        if ($HAS_VALID_FORM){
            $imageID = $_SESSION['amend_img_id']; //We update the profile_image_id whatever happens

            //Check for new image - this is optional
            if ($_FILES[$imageEl]['error'] == 0){
                $image = $_FILES[$imageEl];
                $image_filename = $image['name'];
                $image_info = getimagesize($image['tmp_name']);
                $image_mime_type = $image_info['mime'];
                $image_size = $image['size'];
                $image_data = file_get_contents($image['tmp_name']);
    
                $escapedImgeFile = $conn->real_escape_string($image_filename);
                $escapedImageMimeType = $conn->real_escape_string($image_mime_type);
                $escapedImgeSize = $conn->real_escape_string($image_size);

                //Check we have an existing image to replace
                if (\helpers\Helper::ExistsInDatabase($conn, "mon_profile_images", "id", $imageID)){
                    $query_string = "UPDATE mon_profile_images SET filename=?, mime_type=?, file_size=?, image_data=? WHERE id=$imageID";
                    $stmt = $conn->prepare($query_string);
                    $stmt->bind_param('ssds', $escapedImgeFile, $escapedImageMimeType, $escapedImgeSize, $image_data);
                    $stmt->execute() or die("Sorry, there was an error updating image: " . $conn->error);
                }
                else { //Create a new image and update the ID
                    $query_string = "INSERT INTO mon_profile_images (filename, mime_type, file_size, image_data) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query_string);
                    $stmt->bind_param('ssds', $escapedImgeFile, $escapedImageMimeType,
                    $escapedImgeSize, $image_data);

                    if ($stmt->execute()){
                        $imageID = $conn->insert_id; //Get the image id
                    }
                    else {
                        die("Sorry, there was an error uploading the image. Error: " . $conn->error);
                    }
                }
            }

            //Amen Mon Data
            $target_id = $_SESSION['amend_id'];
            $query_string = "UPDATE mons SET name=?, primary_type=?, secondary_type=?, bio=?, profile_image_id=? WHERE id=$target_id";
            $stmt = $conn->prepare($query_string);
            $stmt->bind_param('siisi', $monNameValue, $primeTypeValue, $secondTypeValue, $bioValue, $imageID);
            $stmt->execute() or die("Sorry, there was an error updating entry: " . $conn->error);
            
            //Set Session
            $_SESSION['title'] = "Amended MySQLMon";
            $_SESSION['message'] = "You amended a MySQLMon!";
            $_SESSION['monID'] = $target_id;
            $_SESSION['monName'] = $monNameValue;
            $_SESSION['primeType'] = $primeTypeValue;
            $_SESSION['secondType'] = $secondTypeValue;
            $_SESSION['bio'] = $bioValue;
            $_SESSION['image_id'] = $imageID;
            $stmt->close();
            $conn->close();
            header('location: sub_pages/results.php');
            exit();
        }
    }