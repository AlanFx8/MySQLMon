<?php
    //Kills the current session
    namespace app {
        class SessionKiller {
            public static function KillSession(){
                session_destroy();
                unset($_SESSION['monID']);
                unset($_SESSION['image_id']);
                unset($_SESSION['title']);
                unset($_SESSION['message']);
                unset($_SESSION['monName']);
                unset($_SESSION['primeType']);
                unset($_SESSION['secondType']);
                unset($_SESSION['bio']);
                unset($_SESSION['amend_id']);
                unset($_SESSION['amend_img_id']);
                unset($_SESSION['originalName']);
            }
        }
    }