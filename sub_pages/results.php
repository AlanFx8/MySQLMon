<?php
    //Shows the finished MySQLMon
    namespace app {
        session_start();
        require_once '../assets/scripts/autoloader.php';
        use \builders\SiteBuilder as _outline;
        use \app\MonData as _data;

        //Build site
        $title = (!isset($_SESSION['title']))?"BLANK":$_SESSION['title'];
        _outline::BuildOpeningSubpage($title);

        if (!isset($_SESSION['monID'])){
            echo "<div>Nothing to see here!</div>";
        }
        else {
            $img_id = $_SESSION['image_id'];
            echo "<div>" . $_SESSION['message'] . "</div>";
            echo "<div>ID: " . $_SESSION["monID"] . "</div>";
            echo "<div>Name: " . $_SESSION["monName"] . "</div>";
            echo "<div>Primary Type: " . _data::$monType[$_SESSION["primeType"]] . "</div>";
            echo "<div>Secondary Type: " . _data::$monType[$_SESSION["secondType"]] . "</div>";
            echo "<div>Bio: " . nl2br($_SESSION["bio"]) . "</div>";
            echo "<div><img src='../assets/scripts/show_mon_image.php?image_id=$img_id' alt='Preview image' /></div>";

            //We're done, clear the SESSION
            SessionKiller::KillSession();
        }

        _outline::BuildClosing();
    }