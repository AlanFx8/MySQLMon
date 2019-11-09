<?php
    namespace app {
        require_once 'assets/scripts/controllers/create_mon_controller.php';
        use \builders\SiteBuilder as _outline;
        use \builders\MonFormBuilder as _form;
        use \app\MonData as _data;

        //Build site
        _outline::BuildOpening("MySQLMon: Creation Form");

        //Handle Errors
        \helpers\Errors::ListErrors($errors);

        //Build Form
        _form::BuildForm("create_mon", "createMonForm", "createMonBTN", "SUBMIT MYSQLMON", $monNameValue, _data::$monType, $secondTypeValue, $primeTypeValue, $bioValue);

        //Build Closing Elements
        _outline::BuildClosing();
    }