<?php
    namespace app {
        require_once 'assets/scripts/controllers/amend_mon_controller.php';
        use \builders\SiteBuilder as _outline;
        use \builders\MonFormBuilder as _form;
        use \app\MonData as _data;

        //Build Opening Elements
        _outline::BuildOpening("MySQLMon: Amend MySQLMon");

        //Build the Mon Buttons
        \builders\MonNavBuilder::BuildNavigation($conn, _data::$monTypeColor);

        //Build AmendMonWrapper
        echo "<div id='amendMonWrapper'>";
        //Handle Errors
        \helpers\Errors::ListErrors($errors);

        //Form
        $result = MonIDRequest::GetRequest($conn);
        if ($result != false){
            $id = $_REQUEST['id'];
            $_SESSION['amend_id'] = $id; //We need to save the ID as the Submit Button will reset the request array
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $monNameValue = $row['name'];
            $primeTypeValue = $row['primary_type'];
            $secondTypeValue = $row['secondary_type'];
            $bioValue = $row['bio'];
            $_SESSION['amend_img_id'] = $row['profile_image_id']; //We need to save this too
            $_SESSION['originalName'] = $monNameValue;
        }

        if(!empty($_SESSION['amend_id']) && empty($_REQUEST['order'])){
            _form::BuildForm("amend_mon", "amendMonForm", "amendMonBTN", "AMEND MYSQLMON", $monNameValue, _data::$monType, $secondTypeValue, $primeTypeValue, $bioValue);
        }
        echo "</div>";

        //Build Closing Elements
        _outline::BuildClosingJS(array(0 => 'amend_helper'));
    }