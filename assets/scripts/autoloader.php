<?php
    //A modified version of the autoloader made by Joe Sexton <joe.sexton@bigideas.com> at:
    //https://www.webtipblog.com/using-spl_autoload_register-load-classes-php-project/
    spl_autoload_register('autoload');

    function autoload($class, $dir = null) {
        //We only want the class name, not the namespace
        $lastSlashPos = strrpos($class, "\\");
        if ($lastSlashPos !== false){
            $class = substr($class, $lastSlashPos+1);
        }

        //We start at the site root (not ./) so classes in subfolders can use it
        if (is_null($dir))
            $dir = 'C:/wamp64/www/ProjectMySQLMon/MySQLMonV2/assets/scripts/';

        //Go through each folder until we get the class
        foreach (scandir($dir) as $file) {
            if (is_dir($dir.$file) && substr($file, 0, 1) !== '.')
                autoload($class, $dir.$file.'/');

            if (substr($file, 0, 2) !== '._' && preg_match("/.php$/i" , $file)) {
                if (str_replace('.php', '', $file) == $class || str_replace('.class.php', '', $file) == $class) {
                    include $dir . $file;
                }
            }
        }
    }