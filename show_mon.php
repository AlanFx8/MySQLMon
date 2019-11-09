<?php
    namespace app {
        session_start();
        require_once 'assets/scripts/autoloader.php';
        require_once 'assets/scripts/conn/db.php';
        use \builders\SiteBuilder as _outline;
        use \app\MonData as _data;

        //Build Opening Elements
        _outline::BuildOpening("MySQLMon: Show List");

        //Build the MySQLMon Buttons
        \builders\MonNavBuilder::BuildNavigation($conn, _data::$monTypeColor);

        //Build the Mon Show
        echo "<div id='showMonWrapper'>";
            //A hack to reshow the selected MySQLMon after we click on an order buttton
            //We need to use REQUEST instead of GET to do this
            if (empty($_REQUEST['id']) && !empty($_SESSION['mon_id'])){
                $_REQUEST['id'] = $_SESSION['mon_id'];
            }

            //Check for request and show its data
            $result = MonIDRequest::GetRequest($conn);
            if ($result == false)
                return;
            $id = $_REQUEST['id'];
            $_SESSION['mon_id'] = $id;
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $name = $row['name'];
            $primeType = _data::$monType[$row['primary_type']];
            $secondType = _data::$monType[$row['secondary_type']];
            $bio = nl2br($row['bio']);
            $img_id = $row['profile_image_id'];
            echo "$id: $name<br/>";
            echo "Primary Type: $primeType<br/>";
            echo "Seconday Type: $secondType<br/>";
            echo "Bio: $bio<br/>";
            echo "<div><img src='assets/scripts/show_mon_image.php?image_id=$img_id' title='$name' alt='MySQLMon image' /></div>";
        echo "</div>";
        $conn->close();
        
        //Build Closing Elements
        _outline::BuildClosing();
    }