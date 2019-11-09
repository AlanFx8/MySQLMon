<?php
    //Uses an ID to load the image of a MySQLMon
    require_once 'conn/db.php';
    try {
        if (!isset($_GET['image_id'])){
            die("Error: No image ID found.");
        }

        $image_id = $_GET['image_id'];

        //Run Query
        $query = sprintf("SELECT * FROM mon_profile_images WHERE id = %d LIMIT 1", $image_id);
        $result = $conn->query($query) or die($conn->error);

        if (!$result || $result->num_rows == 0){
            die("Error: ID returned no image");
        }

        //Get data from query
        $image = $result->fetch_array(MYSQLI_ASSOC);

        //Set headers
        header('Content-type: ' . $image['mime_type']);
        header('Content-length: ' . $image['file_size']);

        //Send the image
        echo $image['image_data'];
    }
    catch (Exception $exc){
        die("Sorry, there was an error: " . $exc->getMessage());
    }